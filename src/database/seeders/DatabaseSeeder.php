<?php

namespace Database\Seeders;

use App\Models\ApprovalWorkflow;
use App\Models\ApprovalWorkflowStep;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JobOrder;
use App\Models\JobOrderApproval;
use App\Models\Objective;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private function createEmployee(string $name, string $email, Position $position): void
    {
        $user = User::firstOrCreate([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password')
        ]);

        Employee::firstOrCreate([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'employee_id_number' => 'EMP'.str_pad($user->id, 4, '0', STR_PAD_LEFT)
        ]);
    }
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
        // Panggil seeder lain jika diperlukan di sini
        // $this->call([
        //     RoleSeeder::class,
        //     UserSeeder::class,
        // ]);

        // 1. Company
        $company = Company::firstOrCreate(
            ['name' => 'PT Gajah Tunggal Tbk'],
            [
                'address' => 'Jl. Raya Cakung Cilincing No.1, Jakarta Utara', 'phone' => '021-12345678',
                'email' => 'corporate@gt-tires.com', 'website' => 'www.gt-tires.com',
                'state' => 'DKI Jakarta', 'country' => 'Indonesia', 'postal_code' => '14130'
            ]
        );

        // 2. Departments
        $deptEng = Department::firstOrCreate(['company_id' => $company->id, 'name' => 'Engineering']);
        $deptProd = Department::firstOrCreate(['company_id' => $company->id, 'name' => 'Produksi']);
        $deptGudang = Department::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'Gudang ARM1'],
            ['cost_center_code' => '140501-8001000050']
        );

        // 3. Positions (Corrected column from 'name' to 'name')
        $posDeptHeadEng = Position::firstOrCreate(['department_id' => $deptEng->id, 'name' => 'Department Head Engineering']);
        $posPlantHead = Position::firstOrCreate(['department_id' => $deptProd->id, 'name' => 'Plant Head']);
        $posFactoryHead = Position::firstOrCreate(['department_id' => $deptProd->id, 'name' => 'Factory Head']);
        $posDeptHeadGudang = Position::firstOrCreate(['department_id' => $deptGudang->id, 'name' => 'Department Head Gudang']);
        $posStaffGudang = Position::firstOrCreate(['department_id' => $deptGudang->id, 'name' => 'Staff Gudang']);


        // 4. Users and Employees (mereplikasi nama dari form)
        $this->createEmployee('Aprial', 'aprial@example.com', $posStaffGudang);
        $this->createEmployee('Suwoli', 'suwoli@example.com', $posStaffGudang);
        $this->createEmployee('Budiman', 'budiman@example.com', $posDeptHeadGudang);
        $this->createEmployee('Edward S', 'edward.s@example.com', $posPlantHead);
        $this->createEmployee('Terry O', 'terry.o@example.com', $posFactoryHead);
        $this->createEmployee('Arif B', 'arif.b@example.com', $posDeptHeadEng);

        // 5. Objectives
        $objectives = [
            'Produksi Baru', 'Produksi Naik', 'Quality Naik', 'Mengurangi Tenaga',
            'Menurunkan Scrapt', 'Keselamatan', 'Penggantian', 'Cadangan', 'Dll'
        ];
        foreach ($objectives as $objective) {
            Objective::firstOrCreate(['name' => $objective]);
        }

        // 6. Approval Workflows
        $workflowGudang = ApprovalWorkflow::firstOrCreate(
            ['name' => 'Alur Persetujuan Job Order Gudang'],
            ['department_id' => $deptGudang->id]
        );

        // Definisikan langkah-langkahnya sesuai urutan di form
        ApprovalWorkflowStep::firstOrCreate(['approval_workflow_id' => $workflowGudang->id, 'step' => 1], ['position_id' => $posDeptHeadGudang->id]);
        ApprovalWorkflowStep::firstOrCreate(['approval_workflow_id' => $workflowGudang->id, 'step' => 2], ['position_id' => $posPlantHead->id]);
        ApprovalWorkflowStep::firstOrCreate(['approval_workflow_id' => $workflowGudang->id, 'step' => 3], ['position_id' => $posFactoryHead->id]);
        ApprovalWorkflowStep::firstOrCreate(['approval_workflow_id' => $workflowGudang->id, 'step' => 4], ['position_id' => $posDeptHeadEng->id]);

        // 7. Replikasi Job Order dari Form
        $requester = User::where('name', 'Aprial')->firstOrFail()->employee;
        $recipient = User::where('name', 'Suwoli')->firstOrFail()->employee;
        $objectiveKeselamatan = Objective::where('name', 'Keselamatan')->first();

        $jobOrder = JobOrder::firstOrCreate(
            ['job_order_number' => '267/SPK/P4/XII/23'],
            [
                'job_order_date' => '2023-12-01',
                'work_description' => 'Penggantian lampu penerangan LED Area Gudang ARM1 Pintu 10 sebanyak 9 titik & penambahan sebanyak 6 titik',
                'work_type' => 'installation',
                'department_id' => $requester->position->department_id,
                'requester_id' => $requester->id,
                'recipient_id' => $recipient->id,
                'status' => 'in_progress',
            ]
        );

        // Lampirkan Tujuan (Objective) ke Job Order secara idempotent
        $jobOrder->objectives()->syncWithoutDetaching([$objectiveKeselamatan->id]);

        // Buat entri approval berdasarkan workflow & simulasikan approval yang sudah terjadi
        foreach ($workflowGudang->steps as $step) {
            $approverUser = User::whereHas('employee.position', fn ($query) => $query->where('id', $step->position_id))->first();

            if ($approverUser) {
                $isApproved = in_array($approverUser->name, ['Budiman', 'Edward S', 'Terry O', 'Arif B']);

                JobOrderApproval::firstOrCreate(
                    [
                        'job_order_id' => $jobOrder->id,
                        'approval_workflow_step_id' => $step->id,
                    ],
                    [
                        'employee_id' => $isApproved ? $approverUser->employee->id : null,
                        'status' => $isApproved ? 'approved' : 'pending',
                        'approved_at' => $isApproved ? Carbon::parse($jobOrder->job_order_date)->addDays(rand(2, 6)) : null,
                    ]
                );
            }
        }
    }
}

