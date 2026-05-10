<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\AvailabilitySlot;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Users ---
        $admin = User::create([
            'name'     => 'System Admin',
            'email'    => 'admin@booking.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '03001234567',
            'status'   => 'active',
        ]);

        $staff = User::create([
            'name'     => 'Dr. Sarah Johnson',
            'email'    => 'staff@booking.com',
            'password' => Hash::make('password'),
            'role'     => 'staff',
            'phone'    => '03009876543',
            'status'   => 'active',
        ]);

        $staff2 = User::create([
            'name'     => 'Dr. James Lee',
            'email'    => 'staff2@booking.com',
            'password' => Hash::make('password'),
            'role'     => 'staff',
            'phone'    => '03011112222',
            'status'   => 'active',
        ]);

        $customer = User::create([
            'name'     => 'Ali Khan',
            'email'    => 'customer@booking.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '03334567890',
            'status'   => 'active',
        ]);

        $customer2 = User::create([
            'name'     => 'Sara Ahmed',
            'email'    => 'customer2@booking.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '03445678901',
            'status'   => 'active',
        ]);

        // --- Services ---
        $services = Service::insert([
            ['title' => 'General Consultation', 'description' => 'A general health check-up and consultation with a qualified doctor.', 'duration' => 30, 'price' => 500.00, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Dental Cleaning',       'description' => 'Professional dental cleaning and oral hygiene assessment.',          'duration' => 45, 'price' => 800.00, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Eye Examination',       'description' => 'Comprehensive vision test and eye health examination.',             'duration' => 40, 'price' => 600.00, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Physiotherapy Session', 'description' => 'One-on-one physical therapy session for rehabilitation.',           'duration' => 60, 'price' => 1200.00,'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Mental Health Counseling','description' => 'Confidential counseling session with a licensed therapist.',     'duration' => 60, 'price' => 1500.00,'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Blood Test Panel',      'description' => 'Comprehensive blood work and laboratory analysis.',                'duration' => 20, 'price' => 350.00, 'status' => 'inactive','created_at' => now(), 'updated_at' => now()],
        ]);

        $s1 = Service::find(1);
        $s2 = Service::find(2);
        $s3 = Service::find(3);
        $s4 = Service::find(4);
        $s5 = Service::find(5);

        // --- Availability Slots (next 7 days) ---
        $times = [
            ['09:00', '09:30'],
            ['09:30', '10:00'],
            ['10:00', '10:30'],
            ['10:30', '11:00'],
            ['11:00', '11:30'],
            ['14:00', '14:30'],
            ['14:30', '15:00'],
            ['15:00', '15:30'],
        ];

        $slotIds = [];
        for ($i = 1; $i <= 7; $i++) {
            $date = now()->addDays($i)->format('Y-m-d');
            foreach ($times as $time) {
                $slot = AvailabilitySlot::create([
                    'staff_id'   => $staff->id,
                    'service_id' => $s1->id,
                    'date'       => $date,
                    'start_time' => $time[0],
                    'end_time'   => $time[1],
                    'is_booked'  => false,
                    'status'     => 'available',
                ]);
                $slotIds[] = $slot->id;
            }
        }

        // Slots for staff2
        for ($i = 1; $i <= 5; $i++) {
            $date = now()->addDays($i)->format('Y-m-d');
            foreach (array_slice($times, 0, 4) as $time) {
                AvailabilitySlot::create([
                    'staff_id'   => $staff2->id,
                    'service_id' => $s2->id,
                    'date'       => $date,
                    'start_time' => $time[0],
                    'end_time'   => $time[1],
                    'is_booked'  => false,
                    'status'     => 'available',
                ]);
            }
        }

        // --- Sample Appointments ---
        // Book slot 1 (mark as booked)
        $slot1 = AvailabilitySlot::find($slotIds[0]);
        $slot1->update(['is_booked' => true]);

        Appointment::create([
            'customer_id' => $customer->id,
            'staff_id'    => $staff->id,
            'service_id'  => $s1->id,
            'slot_id'     => $slot1->id,
            'status'      => 'approved',
            'remarks'     => 'Follow-up on blood pressure medication.',
            'booked_at'   => now(),
        ]);

        // Book slot 2 (pending)
        $slot2 = AvailabilitySlot::find($slotIds[1]);
        $slot2->update(['is_booked' => true]);

        Appointment::create([
            'customer_id' => $customer2->id,
            'staff_id'    => $staff->id,
            'service_id'  => $s1->id,
            'slot_id'     => $slot2->id,
            'status'      => 'pending',
            'remarks'     => 'First time consultation.',
            'booked_at'   => now(),
        ]);
    }
}
