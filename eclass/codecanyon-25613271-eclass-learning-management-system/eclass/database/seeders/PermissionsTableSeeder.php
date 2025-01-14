<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'dashboard.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:37:17',
                'updated_at' => '2022-03-08 11:37:17',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'users.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:39:12',
                'updated_at' => '2022-03-08 11:39:12',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'users.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:39:12',
                'updated_at' => '2022-03-08 11:39:12',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'users.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:39:12',
                'updated_at' => '2022-03-08 11:39:12',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'users.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:39:12',
                'updated_at' => '2022-03-08 11:39:12',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'marketing-dashboard.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:40:34',
                'updated_at' => '2022-03-08 11:40:34',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'categories.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:42:23',
                'updated_at' => '2022-03-08 11:42:23',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'categories.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:42:23',
                'updated_at' => '2022-03-08 11:42:23',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'categories.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:42:23',
                'updated_at' => '2022-03-08 11:42:23',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'categories.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 11:42:23',
                'updated_at' => '2022-03-08 11:42:23',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'instructor-pending-request.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 12:43:32',
                'updated_at' => '2022-03-08 12:43:32',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'instructor-instructor-plan.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 12:47:07',
                'updated_at' => '2022-03-08 12:47:07',
            ),
            12 => 
            array (
                'id' => 14,
                'name' => 'multiple-instructor.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-08 12:58:10',
                'updated_at' => '2022-03-08 12:58:10',
            ),
            13 => 
            array (
                'id' => 15,
                'name' => 'instructor-payout-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 04:32:26',
                'updated_at' => '2022-03-09 04:32:26',
            ),
            14 => 
            array (
                'id' => 16,
                'name' => 'instructor-pending-payout.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 04:34:25',
                'updated_at' => '2022-03-09 04:34:25',
            ),
            15 => 
            array (
                'id' => 17,
                'name' => 'instructor-completed-payout.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 04:36:24',
                'updated_at' => '2022-03-09 04:36:24',
            ),
            16 => 
            array (
                'id' => 18,
                'name' => 'certificate.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:19:25',
                'updated_at' => '2022-03-09 05:19:25',
            ),
            17 => 
            array (
                'id' => 19,
                'name' => 'followers.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:22:55',
                'updated_at' => '2022-03-09 05:22:55',
            ),
            18 => 
            array (
                'id' => 20,
                'name' => 'affiliate.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:24:12',
                'updated_at' => '2022-03-09 05:24:12',
            ),
            19 => 
            array (
                'id' => 21,
                'name' => 'wallet-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:25:03',
                'updated_at' => '2022-03-09 05:25:03',
            ),
            20 => 
            array (
                'id' => 22,
                'name' => 'wallet-transactions.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:26:59',
                'updated_at' => '2022-03-09 05:26:59',
            ),
            21 => 
            array (
                'id' => 23,
                'name' => 'push-notification.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:28:13',
                'updated_at' => '2022-03-09 05:28:13',
            ),
            22 => 
            array (
                'id' => 24,
                'name' => 'attendance.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:29:13',
                'updated_at' => '2022-03-09 05:29:13',
            ),
            23 => 
            array (
                'id' => 25,
                'name' => 'orders.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:29:43',
                'updated_at' => '2022-03-09 05:29:43',
            ),
            24 => 
            array (
                'id' => 26,
                'name' => 'report.quiz-report.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:30:46',
                'updated_at' => '2022-03-09 05:30:46',
            ),
            25 => 
            array (
                'id' => 28,
                'name' => 'report.progress-report.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:31:48',
                'updated_at' => '2022-03-09 05:31:48',
            ),
            26 => 
            array (
                'id' => 29,
                'name' => 'report.revenue-admin-report.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:37:29',
                'updated_at' => '2022-03-09 05:37:29',
            ),
            27 => 
            array (
                'id' => 30,
                'name' => 'report.revenue-instructor-report.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:39:07',
                'updated_at' => '2022-03-09 05:39:07',
            ),
            28 => 
            array (
                'id' => 31,
                'name' => 'financial-reports.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:40:31',
                'updated_at' => '2022-03-09 05:40:31',
            ),
            29 => 
            array (
                'id' => 32,
                'name' => 'device-history.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:42:07',
                'updated_at' => '2022-03-09 05:42:07',
            ),
            30 => 
            array (
                'id' => 33,
                'name' => 'forum-discussion.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 05:56:45',
                'updated_at' => '2022-03-09 05:56:45',
            ),
            31 => 
            array (
                'id' => 34,
                'name' => 'about.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 06:53:56',
                'updated_at' => '2022-03-09 06:53:56',
            ),
            32 => 
            array (
                'id' => 35,
                'name' => 'career.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 06:54:32',
                'updated_at' => '2022-03-09 06:54:32',
            ),
            33 => 
            array (
                'id' => 36,
                'name' => 'contact-us.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 06:55:32',
                'updated_at' => '2022-03-09 06:55:32',
            ),
            34 => 
            array (
                'id' => 37,
                'name' => 'job.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 06:56:03',
                'updated_at' => '2022-03-09 06:56:03',
            ),
            35 => 
            array (
                'id' => 38,
                'name' => 'resume.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 06:56:28',
                'updated_at' => '2022-03-09 06:56:28',
            ),
            36 => 
            array (
                'id' => 39,
                'name' => 'get-api-key.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 06:57:13',
                'updated_at' => '2022-03-09 06:57:13',
            ),
            37 => 
            array (
                'id' => 40,
                'name' => 'themes.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 06:57:51',
                'updated_at' => '2022-03-09 06:57:51',
            ),
            38 => 
            array (
                'id' => 41,
                'name' => 'homepage-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 06:59:08',
                'updated_at' => '2022-03-09 06:59:08',
            ),
            39 => 
            array (
                'id' => 42,
                'name' => 'category-sliders.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:05:05',
                'updated_at' => '2022-03-09 07:05:05',
            ),
            40 => 
            array (
                'id' => 43,
                'name' => 'get-started.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:05:38',
                'updated_at' => '2022-03-09 07:05:38',
            ),
            41 => 
            array (
                'id' => 44,
                'name' => 'widget.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:06:36',
                'updated_at' => '2022-03-09 07:06:36',
            ),
            42 => 
            array (
                'id' => 45,
                'name' => 'coming-soon.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:07:03',
                'updated_at' => '2022-03-09 07:07:03',
            ),
            43 => 
            array (
                'id' => 46,
                'name' => 'terms-condition.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:07:38',
                'updated_at' => '2022-03-09 07:07:38',
            ),
            44 => 
            array (
                'id' => 47,
                'name' => 'privacy-policy.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:08:40',
                'updated_at' => '2022-03-09 07:08:40',
            ),
            45 => 
            array (
                'id' => 48,
                'name' => 'invoice-design.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:09:45',
                'updated_at' => '2022-03-09 07:09:45',
            ),
            46 => 
            array (
                'id' => 49,
                'name' => 'login-signup.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:12:10',
                'updated_at' => '2022-03-09 07:12:10',
            ),
            47 => 
            array (
                'id' => 50,
                'name' => 'video-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:12:50',
                'updated_at' => '2022-03-09 07:12:50',
            ),
            48 => 
            array (
                'id' => 51,
                'name' => 'breadcum-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:13:53',
                'updated_at' => '2022-03-09 07:13:53',
            ),
            49 => 
            array (
                'id' => 52,
                'name' => 'join-an-instructor.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:14:59',
                'updated_at' => '2022-03-09 07:14:59',
            ),
            50 => 
            array (
                'id' => 53,
                'name' => 'settings.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:15:31',
                'updated_at' => '2022-03-09 07:15:31',
            ),
            51 => 
            array (
                'id' => 54,
                'name' => 'pwa.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:16:05',
                'updated_at' => '2022-03-09 07:16:05',
            ),
            52 => 
            array (
                'id' => 55,
                'name' => 'adsense-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:17:50',
                'updated_at' => '2022-03-09 07:17:50',
            ),
            53 => 
            array (
                'id' => 56,
                'name' => 'twilio-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:18:58',
                'updated_at' => '2022-03-09 07:18:58',
            ),
            54 => 
            array (
                'id' => 57,
                'name' => 'site-map-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:19:32',
                'updated_at' => '2022-03-09 07:19:32',
            ),
            55 => 
            array (
                'id' => 58,
                'name' => 'email-design.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:20:15',
                'updated_at' => '2022-03-09 07:20:15',
            ),
            56 => 
            array (
                'id' => 59,
                'name' => 'payment-setting-credentials.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:25:19',
                'updated_at' => '2022-03-09 07:25:19',
            ),
            57 => 
            array (
                'id' => 60,
                'name' => 'payment-setting-MPESA-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:27:12',
                'updated_at' => '2022-03-09 07:27:12',
            ),
            58 => 
            array (
                'id' => 61,
                'name' => 'payment-setting-bank-details.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:29:16',
                'updated_at' => '2022-03-09 07:29:16',
            ),
            59 => 
            array (
                'id' => 62,
                'name' => 'player-settings.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:30:21',
                'updated_at' => '2022-03-09 07:30:21',
            ),
            60 => 
            array (
                'id' => 63,
                'name' => 'update-process.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:31:42',
                'updated_at' => '2022-03-09 07:31:42',
            ),
            61 => 
            array (
                'id' => 64,
                'name' => 'help-support-import-demo.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:34:09',
                'updated_at' => '2022-03-09 07:34:09',
            ),
            62 => 
            array (
                'id' => 65,
                'name' => 'help-support-database-backup.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:35:23',
                'updated_at' => '2022-03-09 07:35:23',
            ),
            63 => 
            array (
                'id' => 66,
                'name' => 'help-support-remove-public.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:36:24',
                'updated_at' => '2022-03-09 07:36:24',
            ),
            64 => 
            array (
                'id' => 67,
                'name' => 'help-support-clear-cache.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:37:23',
                'updated_at' => '2022-03-09 07:37:23',
            ),
            65 => 
            array (
                'id' => 68,
                'name' => 'review-rating.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:42:25',
                'updated_at' => '2022-03-09 07:42:25',
            ),
            66 => 
            array (
                'id' => 69,
                'name' => 'review-reports.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:44:15',
                'updated_at' => '2022-03-09 07:44:15',
            ),
            67 => 
            array (
                'id' => 70,
                'name' => 'appointment.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:46:06',
                'updated_at' => '2022-03-09 07:46:06',
            ),
            68 => 
            array (
                'id' => 71,
                'name' => 'rejected-courses.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:47:22',
                'updated_at' => '2022-03-09 07:47:22',
            ),
            69 => 
            array (
                'id' => 72,
                'name' => 'assignment.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:49:04',
                'updated_at' => '2022-03-09 07:49:04',
            ),
            70 => 
            array (
                'id' => 73,
                'name' => 'quiz-review.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:50:31',
                'updated_at' => '2022-03-09 07:50:31',
            ),
            71 => 
            array (
                'id' => 74,
                'name' => 'payout-setting.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:51:26',
                'updated_at' => '2022-03-09 07:51:26',
            ),
            72 => 
            array (
                'id' => 75,
                'name' => 'vacation-enable.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 07:52:01',
                'updated_at' => '2022-03-09 07:52:01',
            ),
            73 => 
            array (
                'id' => 76,
                'name' => 'subcategories.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:41:59',
                'updated_at' => '2022-03-09 08:41:59',
            ),
            74 => 
            array (
                'id' => 77,
                'name' => 'subcategories.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:41:59',
                'updated_at' => '2022-03-09 08:41:59',
            ),
            75 => 
            array (
                'id' => 78,
                'name' => 'subcategories.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:41:59',
                'updated_at' => '2022-03-09 08:41:59',
            ),
            76 => 
            array (
                'id' => 79,
                'name' => 'subcategories.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:42:00',
                'updated_at' => '2022-03-09 08:42:00',
            ),
            77 => 
            array (
                'id' => 80,
                'name' => 'childcategories.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:44:58',
                'updated_at' => '2022-03-09 08:44:58',
            ),
            78 => 
            array (
                'id' => 81,
                'name' => 'childcategories.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:44:58',
                'updated_at' => '2022-03-09 08:44:58',
            ),
            79 => 
            array (
                'id' => 82,
                'name' => 'childcategories.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:44:58',
                'updated_at' => '2022-03-09 08:44:58',
            ),
            80 => 
            array (
                'id' => 83,
                'name' => 'childcategories.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:44:58',
                'updated_at' => '2022-03-09 08:44:58',
            ),
            81 => 
            array (
                'id' => 84,
                'name' => 'courses.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:46:10',
                'updated_at' => '2022-03-09 08:46:10',
            ),
            82 => 
            array (
                'id' => 85,
                'name' => 'courses.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:46:10',
                'updated_at' => '2022-03-09 08:46:10',
            ),
            83 => 
            array (
                'id' => 86,
                'name' => 'courses.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:46:10',
                'updated_at' => '2022-03-09 08:46:10',
            ),
            84 => 
            array (
                'id' => 87,
                'name' => 'courses.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 08:46:10',
                'updated_at' => '2022-03-09 08:46:10',
            ),
            85 => 
            array (
                'id' => 88,
                'name' => 'bundle-courses.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:17:25',
                'updated_at' => '2022-03-09 10:17:25',
            ),
            86 => 
            array (
                'id' => 89,
                'name' => 'bundle-courses.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:17:25',
                'updated_at' => '2022-03-09 10:17:25',
            ),
            87 => 
            array (
                'id' => 90,
                'name' => 'bundle-courses.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:17:25',
                'updated_at' => '2022-03-09 10:17:25',
            ),
            88 => 
            array (
                'id' => 91,
                'name' => 'bundle-courses.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:17:25',
                'updated_at' => '2022-03-09 10:17:25',
            ),
            89 => 
            array (
                'id' => 92,
                'name' => 'course-languages.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:19:43',
                'updated_at' => '2022-03-09 10:19:43',
            ),
            90 => 
            array (
                'id' => 93,
                'name' => 'course-languages.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:19:43',
                'updated_at' => '2022-03-09 10:19:43',
            ),
            91 => 
            array (
                'id' => 94,
                'name' => 'course-languages.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:19:43',
                'updated_at' => '2022-03-09 10:19:43',
            ),
            92 => 
            array (
                'id' => 95,
                'name' => 'course-languages.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:19:43',
                'updated_at' => '2022-03-09 10:19:43',
            ),
            93 => 
            array (
                'id' => 96,
                'name' => 'course-reviews.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:22:21',
                'updated_at' => '2022-03-09 10:22:21',
            ),
            94 => 
            array (
                'id' => 97,
                'name' => 'course-reviews.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:22:21',
                'updated_at' => '2022-03-09 10:22:21',
            ),
            95 => 
            array (
                'id' => 98,
                'name' => 'course-reviews.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:22:21',
                'updated_at' => '2022-03-09 10:22:21',
            ),
            96 => 
            array (
                'id' => 99,
                'name' => 'course-reviews.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:22:21',
                'updated_at' => '2022-03-09 10:22:21',
            ),
            97 => 
            array (
                'id' => 100,
                'name' => 'assignment.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:24:16',
                'updated_at' => '2022-03-09 10:24:16',
            ),
            98 => 
            array (
                'id' => 101,
                'name' => 'assignment.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:24:16',
                'updated_at' => '2022-03-09 10:24:16',
            ),
            99 => 
            array (
                'id' => 102,
                'name' => 'assignment.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:24:16',
                'updated_at' => '2022-03-09 10:24:16',
            ),
            100 => 
            array (
                'id' => 103,
                'name' => 'assignment.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:24:16',
                'updated_at' => '2022-03-09 10:24:16',
            ),
            101 => 
            array (
                'id' => 104,
                'name' => 'refund-policy.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:24:46',
                'updated_at' => '2022-03-09 10:24:46',
            ),
            102 => 
            array (
                'id' => 105,
                'name' => 'refund-policy.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:24:46',
                'updated_at' => '2022-03-09 10:24:46',
            ),
            103 => 
            array (
                'id' => 106,
                'name' => 'refund-policy.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:24:46',
                'updated_at' => '2022-03-09 10:24:46',
            ),
            104 => 
            array (
                'id' => 107,
                'name' => 'refund-policy.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:24:46',
                'updated_at' => '2022-03-09 10:24:46',
            ),
            105 => 
            array (
                'id' => 108,
                'name' => 'batch.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:25:02',
                'updated_at' => '2022-03-09 10:25:02',
            ),
            106 => 
            array (
                'id' => 109,
                'name' => 'batch.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:25:02',
                'updated_at' => '2022-03-09 10:25:02',
            ),
            107 => 
            array (
                'id' => 110,
                'name' => 'batch.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:25:02',
                'updated_at' => '2022-03-09 10:25:02',
            ),
            108 => 
            array (
                'id' => 111,
                'name' => 'batch.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:25:02',
                'updated_at' => '2022-03-09 10:25:02',
            ),
            109 => 
            array (
                'id' => 112,
                'name' => 'quiz-review.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:25:51',
                'updated_at' => '2022-03-09 10:25:51',
            ),
            110 => 
            array (
                'id' => 113,
                'name' => 'quiz-review.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:25:51',
                'updated_at' => '2022-03-09 10:25:51',
            ),
            111 => 
            array (
                'id' => 114,
                'name' => 'quiz-review.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:25:51',
                'updated_at' => '2022-03-09 10:25:51',
            ),
            112 => 
            array (
                'id' => 115,
                'name' => 'quiz-review.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:25:51',
                'updated_at' => '2022-03-09 10:25:51',
            ),
            113 => 
            array (
                'id' => 116,
                'name' => 'private-course.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:28:54',
                'updated_at' => '2022-03-09 10:28:54',
            ),
            114 => 
            array (
                'id' => 117,
                'name' => 'private-course.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:28:54',
                'updated_at' => '2022-03-09 10:28:54',
            ),
            115 => 
            array (
                'id' => 118,
                'name' => 'private-course.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:28:55',
                'updated_at' => '2022-03-09 10:28:55',
            ),
            116 => 
            array (
                'id' => 119,
                'name' => 'private-course.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:28:55',
                'updated_at' => '2022-03-09 10:28:55',
            ),
            117 => 
            array (
                'id' => 120,
                'name' => 'reported-course.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:29:32',
                'updated_at' => '2022-03-09 10:29:32',
            ),
            118 => 
            array (
                'id' => 121,
                'name' => 'reported-course.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:29:32',
                'updated_at' => '2022-03-09 10:29:32',
            ),
            119 => 
            array (
                'id' => 122,
                'name' => 'reported-course.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:29:32',
                'updated_at' => '2022-03-09 10:29:32',
            ),
            120 => 
            array (
                'id' => 123,
                'name' => 'reported-course.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:29:32',
                'updated_at' => '2022-03-09 10:29:32',
            ),
            121 => 
            array (
                'id' => 124,
                'name' => 'reported-question.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:30:13',
                'updated_at' => '2022-03-09 10:30:13',
            ),
            122 => 
            array (
                'id' => 125,
                'name' => 'reported-question.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:30:13',
                'updated_at' => '2022-03-09 10:30:13',
            ),
            123 => 
            array (
                'id' => 126,
                'name' => 'reported-question.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:30:13',
                'updated_at' => '2022-03-09 10:30:13',
            ),
            124 => 
            array (
                'id' => 127,
                'name' => 'reported-question.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:30:13',
                'updated_at' => '2022-03-09 10:30:13',
            ),
            125 => 
            array (
                'id' => 128,
                'name' => 'meetings.zoom-meetings.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:31:34',
                'updated_at' => '2022-03-09 10:31:34',
            ),
            126 => 
            array (
                'id' => 129,
                'name' => 'meetings.zoom-meetings.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:31:34',
                'updated_at' => '2022-03-09 10:31:34',
            ),
            127 => 
            array (
                'id' => 130,
                'name' => 'meetings.zoom-meetings.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:31:34',
                'updated_at' => '2022-03-09 10:31:34',
            ),
            128 => 
            array (
                'id' => 131,
                'name' => 'meetings.zoom-meetings.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:31:34',
                'updated_at' => '2022-03-09 10:31:34',
            ),
            129 => 
            array (
                'id' => 132,
                'name' => 'meetings.big-blue.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:33:35',
                'updated_at' => '2022-03-09 10:33:35',
            ),
            130 => 
            array (
                'id' => 133,
                'name' => 'meetings.big-blue.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:33:35',
                'updated_at' => '2022-03-09 10:33:35',
            ),
            131 => 
            array (
                'id' => 134,
                'name' => 'meetings.big-blue.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:33:35',
                'updated_at' => '2022-03-09 10:33:35',
            ),
            132 => 
            array (
                'id' => 135,
                'name' => 'meetings.big-blue.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:33:35',
                'updated_at' => '2022-03-09 10:33:35',
            ),
            133 => 
            array (
                'id' => 136,
                'name' => 'meetings.google-meet.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:35:05',
                'updated_at' => '2022-03-09 10:35:05',
            ),
            134 => 
            array (
                'id' => 137,
                'name' => 'meetings.google-meet.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:35:05',
                'updated_at' => '2022-03-09 10:35:05',
            ),
            135 => 
            array (
                'id' => 138,
                'name' => 'meetings.google-meet.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:35:05',
                'updated_at' => '2022-03-09 10:35:05',
            ),
            136 => 
            array (
                'id' => 139,
                'name' => 'meetings.google-meet.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:35:05',
                'updated_at' => '2022-03-09 10:35:05',
            ),
            137 => 
            array (
                'id' => 140,
                'name' => 'meetings.jitsi-meet.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:36:08',
                'updated_at' => '2022-03-09 10:36:08',
            ),
            138 => 
            array (
                'id' => 141,
                'name' => 'meetings.jitsi-meet.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:36:08',
                'updated_at' => '2022-03-09 10:36:08',
            ),
            139 => 
            array (
                'id' => 142,
                'name' => 'meetings.jitsi-meet.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:36:08',
                'updated_at' => '2022-03-09 10:36:08',
            ),
            140 => 
            array (
                'id' => 143,
                'name' => 'meetings.jitsi-meet.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:36:08',
                'updated_at' => '2022-03-09 10:36:08',
            ),
            141 => 
            array (
                'id' => 144,
                'name' => 'meetings.google-classroom.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:37:22',
                'updated_at' => '2022-03-09 10:37:22',
            ),
            142 => 
            array (
                'id' => 145,
                'name' => 'meetings.google-classroom.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:37:22',
                'updated_at' => '2022-03-09 10:37:22',
            ),
            143 => 
            array (
                'id' => 146,
                'name' => 'meetings.google-classroom.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:37:23',
                'updated_at' => '2022-03-09 10:37:23',
            ),
            144 => 
            array (
                'id' => 147,
                'name' => 'meetings.google-classroom.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:37:23',
                'updated_at' => '2022-03-09 10:37:23',
            ),
            145 => 
            array (
                'id' => 148,
                'name' => 'meetings.meeting-recordings.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:38:47',
                'updated_at' => '2022-03-09 10:38:47',
            ),
            146 => 
            array (
                'id' => 149,
                'name' => 'meetings.meeting-recordings.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:38:47',
                'updated_at' => '2022-03-09 10:38:47',
            ),
            147 => 
            array (
                'id' => 150,
                'name' => 'meetings.meeting-recordings.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:38:47',
                'updated_at' => '2022-03-09 10:38:47',
            ),
            148 => 
            array (
                'id' => 151,
                'name' => 'meetings.meeting-recordings.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:38:47',
                'updated_at' => '2022-03-09 10:38:47',
            ),
            149 => 
            array (
                'id' => 152,
                'name' => 'institute.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:40:08',
                'updated_at' => '2022-03-09 10:40:08',
            ),
            150 => 
            array (
                'id' => 153,
                'name' => 'institute.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:40:08',
                'updated_at' => '2022-03-09 10:40:08',
            ),
            151 => 
            array (
                'id' => 154,
                'name' => 'institute.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:40:08',
                'updated_at' => '2022-03-09 10:40:08',
            ),
            152 => 
            array (
                'id' => 155,
                'name' => 'institute.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:40:08',
                'updated_at' => '2022-03-09 10:40:08',
            ),
            153 => 
            array (
                'id' => 156,
                'name' => 'coupons.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:41:32',
                'updated_at' => '2022-03-09 10:41:32',
            ),
            154 => 
            array (
                'id' => 157,
                'name' => 'coupons.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:41:32',
                'updated_at' => '2022-03-09 10:41:32',
            ),
            155 => 
            array (
                'id' => 158,
                'name' => 'coupons.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:41:33',
                'updated_at' => '2022-03-09 10:41:33',
            ),
            156 => 
            array (
                'id' => 159,
                'name' => 'coupons.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:41:33',
                'updated_at' => '2022-03-09 10:41:33',
            ),
            157 => 
            array (
                'id' => 160,
                'name' => 'flash-deals.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:42:20',
                'updated_at' => '2022-03-09 10:42:20',
            ),
            158 => 
            array (
                'id' => 161,
                'name' => 'flash-deals.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:42:20',
                'updated_at' => '2022-03-09 10:42:20',
            ),
            159 => 
            array (
                'id' => 162,
                'name' => 'flash-deals.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:42:20',
                'updated_at' => '2022-03-09 10:42:20',
            ),
            160 => 
            array (
                'id' => 163,
                'name' => 'flash-deals.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:42:20',
                'updated_at' => '2022-03-09 10:42:20',
            ),
            161 => 
            array (
                'id' => 164,
                'name' => 'blogs.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:42:48',
                'updated_at' => '2022-03-09 10:42:48',
            ),
            162 => 
            array (
                'id' => 165,
                'name' => 'blogs.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:42:49',
                'updated_at' => '2022-03-09 10:42:49',
            ),
            163 => 
            array (
                'id' => 166,
                'name' => 'blogs.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:42:49',
                'updated_at' => '2022-03-09 10:42:49',
            ),
            164 => 
            array (
                'id' => 167,
                'name' => 'blogs.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:42:49',
                'updated_at' => '2022-03-09 10:42:49',
            ),
            165 => 
            array (
                'id' => 168,
                'name' => 'pages.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:43:01',
                'updated_at' => '2022-03-09 10:43:01',
            ),
            166 => 
            array (
                'id' => 169,
                'name' => 'pages.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:43:02',
                'updated_at' => '2022-03-09 10:43:02',
            ),
            167 => 
            array (
                'id' => 170,
                'name' => 'pages.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:43:02',
                'updated_at' => '2022-03-09 10:43:02',
            ),
            168 => 
            array (
                'id' => 171,
                'name' => 'pages.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:43:02',
                'updated_at' => '2022-03-09 10:43:02',
            ),
            169 => 
            array (
                'id' => 172,
                'name' => 'faq.faq-student.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:45:12',
                'updated_at' => '2022-03-09 10:45:12',
            ),
            170 => 
            array (
                'id' => 173,
                'name' => 'faq.faq-student.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:45:12',
                'updated_at' => '2022-03-09 10:45:12',
            ),
            171 => 
            array (
                'id' => 174,
                'name' => 'faq.faq-student.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:45:12',
                'updated_at' => '2022-03-09 10:45:12',
            ),
            172 => 
            array (
                'id' => 175,
                'name' => 'faq.faq-student.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:45:12',
                'updated_at' => '2022-03-09 10:45:12',
            ),
            173 => 
            array (
                'id' => 176,
                'name' => 'faq.faq-instructor.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:45:46',
                'updated_at' => '2022-03-09 10:45:46',
            ),
            174 => 
            array (
                'id' => 177,
                'name' => 'faq.faq-instructor.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:45:46',
                'updated_at' => '2022-03-09 10:45:46',
            ),
            175 => 
            array (
                'id' => 178,
                'name' => 'faq.faq-instructor.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:45:46',
                'updated_at' => '2022-03-09 10:45:46',
            ),
            176 => 
            array (
                'id' => 179,
                'name' => 'faq.faq-instructor.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:45:47',
                'updated_at' => '2022-03-09 10:45:47',
            ),
            177 => 
            array (
                'id' => 180,
                'name' => 'locations.country.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:25',
                'updated_at' => '2022-03-09 10:47:25',
            ),
            178 => 
            array (
                'id' => 181,
                'name' => 'locations.country.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:25',
                'updated_at' => '2022-03-09 10:47:25',
            ),
            179 => 
            array (
                'id' => 182,
                'name' => 'locations.country.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:25',
                'updated_at' => '2022-03-09 10:47:25',
            ),
            180 => 
            array (
                'id' => 183,
                'name' => 'locations.country.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:25',
                'updated_at' => '2022-03-09 10:47:25',
            ),
            181 => 
            array (
                'id' => 184,
                'name' => 'locations.state.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:41',
                'updated_at' => '2022-03-09 10:47:41',
            ),
            182 => 
            array (
                'id' => 185,
                'name' => 'locations.state.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:41',
                'updated_at' => '2022-03-09 10:47:41',
            ),
            183 => 
            array (
                'id' => 186,
                'name' => 'locations.state.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:41',
                'updated_at' => '2022-03-09 10:47:41',
            ),
            184 => 
            array (
                'id' => 187,
                'name' => 'locations.state.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:41',
                'updated_at' => '2022-03-09 10:47:41',
            ),
            185 => 
            array (
                'id' => 188,
                'name' => 'locations.city.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:57',
                'updated_at' => '2022-03-09 10:47:57',
            ),
            186 => 
            array (
                'id' => 189,
                'name' => 'locations.city.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:57',
                'updated_at' => '2022-03-09 10:47:57',
            ),
            187 => 
            array (
                'id' => 190,
                'name' => 'locations.city.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:57',
                'updated_at' => '2022-03-09 10:47:57',
            ),
            188 => 
            array (
                'id' => 191,
                'name' => 'locations.city.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:47:57',
                'updated_at' => '2022-03-09 10:47:57',
            ),
            189 => 
            array (
                'id' => 192,
                'name' => 'currency.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:51:28',
                'updated_at' => '2022-03-09 10:51:28',
            ),
            190 => 
            array (
                'id' => 193,
                'name' => 'currency.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:51:28',
                'updated_at' => '2022-03-09 10:51:28',
            ),
            191 => 
            array (
                'id' => 194,
                'name' => 'currency.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:51:29',
                'updated_at' => '2022-03-09 10:51:29',
            ),
            192 => 
            array (
                'id' => 195,
                'name' => 'currency.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:51:29',
                'updated_at' => '2022-03-09 10:51:29',
            ),
            193 => 
            array (
                'id' => 196,
                'name' => 'front-settings.testimonial.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:59:29',
                'updated_at' => '2022-03-09 10:59:29',
            ),
            194 => 
            array (
                'id' => 197,
                'name' => 'front-settings.testimonial.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:59:29',
                'updated_at' => '2022-03-09 10:59:29',
            ),
            195 => 
            array (
                'id' => 198,
                'name' => 'front-settings.testimonial.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:59:29',
                'updated_at' => '2022-03-09 10:59:29',
            ),
            196 => 
            array (
                'id' => 199,
                'name' => 'front-settings.testimonial.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 10:59:30',
                'updated_at' => '2022-03-09 10:59:30',
            ),
            197 => 
            array (
                'id' => 200,
                'name' => 'front-settings.advertisement.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:02:28',
                'updated_at' => '2022-03-09 11:02:28',
            ),
            198 => 
            array (
                'id' => 201,
                'name' => 'front-settings.advertisement.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:02:28',
                'updated_at' => '2022-03-09 11:02:28',
            ),
            199 => 
            array (
                'id' => 202,
                'name' => 'front-settings.advertisement.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:02:28',
                'updated_at' => '2022-03-09 11:02:28',
            ),
            200 => 
            array (
                'id' => 203,
                'name' => 'front-settings.advertisement.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:02:28',
                'updated_at' => '2022-03-09 11:02:28',
            ),
            201 => 
            array (
                'id' => 204,
                'name' => 'front-settings.sliders.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:04:04',
                'updated_at' => '2022-03-09 11:04:04',
            ),
            202 => 
            array (
                'id' => 205,
                'name' => 'front-settings.sliders.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:04:04',
                'updated_at' => '2022-03-09 11:04:04',
            ),
            203 => 
            array (
                'id' => 206,
                'name' => 'front-settings.sliders.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:04:04',
                'updated_at' => '2022-03-09 11:04:04',
            ),
            204 => 
            array (
                'id' => 207,
                'name' => 'front-settings.sliders.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:04:04',
                'updated_at' => '2022-03-09 11:04:04',
            ),
            205 => 
            array (
                'id' => 208,
                'name' => 'front-settings.fact-slider.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:09:11',
                'updated_at' => '2022-03-09 11:09:11',
            ),
            206 => 
            array (
                'id' => 209,
                'name' => 'front-settings.fact-slider.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:09:11',
                'updated_at' => '2022-03-09 11:09:11',
            ),
            207 => 
            array (
                'id' => 210,
                'name' => 'front-settings.fact-slider.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:09:11',
                'updated_at' => '2022-03-09 11:09:11',
            ),
            208 => 
            array (
                'id' => 211,
                'name' => 'front-settings.fact-slider.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:09:12',
                'updated_at' => '2022-03-09 11:09:12',
            ),
            209 => 
            array (
                'id' => 212,
                'name' => 'front-settings.trusted-sliders.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:12:55',
                'updated_at' => '2022-03-09 11:12:55',
            ),
            210 => 
            array (
                'id' => 213,
                'name' => 'front-settings.trusted-sliders.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:12:55',
                'updated_at' => '2022-03-09 11:12:55',
            ),
            211 => 
            array (
                'id' => 214,
                'name' => 'front-settings.trusted-sliders.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:12:56',
                'updated_at' => '2022-03-09 11:12:56',
            ),
            212 => 
            array (
                'id' => 215,
                'name' => 'front-settings.trusted-sliders.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:12:56',
                'updated_at' => '2022-03-09 11:12:56',
            ),
            213 => 
            array (
                'id' => 216,
                'name' => 'front-settings.seo-directory.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:15:35',
                'updated_at' => '2022-03-09 11:15:35',
            ),
            214 => 
            array (
                'id' => 217,
                'name' => 'front-settings.seo-directory.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:15:35',
                'updated_at' => '2022-03-09 11:15:35',
            ),
            215 => 
            array (
                'id' => 218,
                'name' => 'front-settings.seo-directory.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:15:35',
                'updated_at' => '2022-03-09 11:15:35',
            ),
            216 => 
            array (
                'id' => 219,
                'name' => 'front-settings.seo-directory.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:15:35',
                'updated_at' => '2022-03-09 11:15:35',
            ),
            217 => 
            array (
                'id' => 220,
                'name' => 'front-settings.factsetting.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:34:12',
                'updated_at' => '2022-03-09 11:34:12',
            ),
            218 => 
            array (
                'id' => 221,
                'name' => 'front-settings.factsetting.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:34:12',
                'updated_at' => '2022-03-09 11:34:12',
            ),
            219 => 
            array (
                'id' => 222,
                'name' => 'front-settings.factsetting.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:34:13',
                'updated_at' => '2022-03-09 11:34:13',
            ),
            220 => 
            array (
                'id' => 223,
                'name' => 'front-settings.factsetting.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:34:13',
                'updated_at' => '2022-03-09 11:34:13',
            ),
            221 => 
            array (
                'id' => 224,
                'name' => 'site-settings.language.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:42:22',
                'updated_at' => '2022-03-09 11:42:22',
            ),
            222 => 
            array (
                'id' => 225,
                'name' => 'site-settings.language.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:42:22',
                'updated_at' => '2022-03-09 11:42:22',
            ),
            223 => 
            array (
                'id' => 226,
                'name' => 'site-settings.language.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:42:22',
                'updated_at' => '2022-03-09 11:42:22',
            ),
            224 => 
            array (
                'id' => 227,
                'name' => 'site-settings.language.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:42:22',
                'updated_at' => '2022-03-09 11:42:22',
            ),
            225 => 
            array (
                'id' => 228,
                'name' => 'payment-setting.manual-payment.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:49:47',
                'updated_at' => '2022-03-09 11:49:47',
            ),
            226 => 
            array (
                'id' => 229,
                'name' => 'payment-setting.manual-payment.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:49:47',
                'updated_at' => '2022-03-09 11:49:47',
            ),
            227 => 
            array (
                'id' => 230,
                'name' => 'payment-setting.manual-payment.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:49:47',
                'updated_at' => '2022-03-09 11:49:47',
            ),
            228 => 
            array (
                'id' => 231,
                'name' => 'payment-setting.manual-payment.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:49:48',
                'updated_at' => '2022-03-09 11:49:48',
            ),
            229 => 
            array (
                'id' => 232,
                'name' => 'player-settings.advertise.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:53:02',
                'updated_at' => '2022-03-09 11:53:02',
            ),
            230 => 
            array (
                'id' => 233,
                'name' => 'player-settings.advertise.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:53:02',
                'updated_at' => '2022-03-09 11:53:02',
            ),
            231 => 
            array (
                'id' => 234,
                'name' => 'player-settings.advertise.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:53:02',
                'updated_at' => '2022-03-09 11:53:02',
            ),
            232 => 
            array (
                'id' => 235,
                'name' => 'player-settings.advertise.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:53:02',
                'updated_at' => '2022-03-09 11:53:02',
            ),
            233 => 
            array (
                'id' => 236,
                'name' => 'addon.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:56:20',
                'updated_at' => '2022-03-09 11:56:20',
            ),
            234 => 
            array (
                'id' => 237,
                'name' => 'addon.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:56:20',
                'updated_at' => '2022-03-09 11:56:20',
            ),
            235 => 
            array (
                'id' => 238,
                'name' => 'addon.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:56:20',
                'updated_at' => '2022-03-09 11:56:20',
            ),
            236 => 
            array (
                'id' => 239,
                'name' => 'addon.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 11:56:20',
                'updated_at' => '2022-03-09 11:56:20',
            ),
            237 => 
            array (
                'id' => 240,
                'name' => 'course-includes.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:07:49',
                'updated_at' => '2022-03-09 12:07:49',
            ),
            238 => 
            array (
                'id' => 241,
                'name' => 'course-includes.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:07:49',
                'updated_at' => '2022-03-09 12:07:49',
            ),
            239 => 
            array (
                'id' => 242,
                'name' => 'course-includes.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:07:49',
                'updated_at' => '2022-03-09 12:07:49',
            ),
            240 => 
            array (
                'id' => 243,
                'name' => 'course-includes.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:07:49',
                'updated_at' => '2022-03-09 12:07:49',
            ),
            241 => 
            array (
                'id' => 244,
                'name' => 'what-learn.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:08:56',
                'updated_at' => '2022-03-09 12:08:56',
            ),
            242 => 
            array (
                'id' => 245,
                'name' => 'what-learn.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:08:56',
                'updated_at' => '2022-03-09 12:08:56',
            ),
            243 => 
            array (
                'id' => 246,
                'name' => 'what-learn.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:08:56',
                'updated_at' => '2022-03-09 12:08:56',
            ),
            244 => 
            array (
                'id' => 247,
                'name' => 'what-learn.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:08:56',
                'updated_at' => '2022-03-09 12:08:56',
            ),
            245 => 
            array (
                'id' => 248,
                'name' => 'course-chapter.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:10:56',
                'updated_at' => '2022-03-09 12:10:56',
            ),
            246 => 
            array (
                'id' => 249,
                'name' => 'course-chapter.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:10:56',
                'updated_at' => '2022-03-09 12:10:56',
            ),
            247 => 
            array (
                'id' => 250,
                'name' => 'course-chapter.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:10:56',
                'updated_at' => '2022-03-09 12:10:56',
            ),
            248 => 
            array (
                'id' => 251,
                'name' => 'course-chapter.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:10:56',
                'updated_at' => '2022-03-09 12:10:56',
            ),
            249 => 
            array (
                'id' => 252,
                'name' => 'course-class.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:14:27',
                'updated_at' => '2022-03-09 12:14:27',
            ),
            250 => 
            array (
                'id' => 253,
                'name' => 'course-class.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:14:27',
                'updated_at' => '2022-03-09 12:14:27',
            ),
            251 => 
            array (
                'id' => 254,
                'name' => 'course-class.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:14:27',
                'updated_at' => '2022-03-09 12:14:27',
            ),
            252 => 
            array (
                'id' => 255,
                'name' => 'course-class.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:14:28',
                'updated_at' => '2022-03-09 12:14:28',
            ),
            253 => 
            array (
                'id' => 256,
                'name' => 'related-courses.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:15:11',
                'updated_at' => '2022-03-09 12:15:11',
            ),
            254 => 
            array (
                'id' => 257,
                'name' => 'related-courses.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:15:11',
                'updated_at' => '2022-03-09 12:15:11',
            ),
            255 => 
            array (
                'id' => 258,
                'name' => 'related-courses.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:15:11',
                'updated_at' => '2022-03-09 12:15:11',
            ),
            256 => 
            array (
                'id' => 259,
                'name' => 'related-courses.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:15:12',
                'updated_at' => '2022-03-09 12:15:12',
            ),
            257 => 
            array (
                'id' => 260,
                'name' => 'question.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:15:28',
                'updated_at' => '2022-03-09 12:15:28',
            ),
            258 => 
            array (
                'id' => 261,
                'name' => 'question.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:15:28',
                'updated_at' => '2022-03-09 12:15:28',
            ),
            259 => 
            array (
                'id' => 262,
                'name' => 'question.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:15:29',
                'updated_at' => '2022-03-09 12:15:29',
            ),
            260 => 
            array (
                'id' => 263,
                'name' => 'question.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:15:29',
                'updated_at' => '2022-03-09 12:15:29',
            ),
            261 => 
            array (
                'id' => 264,
                'name' => 'announcement.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:16:51',
                'updated_at' => '2022-03-09 12:16:51',
            ),
            262 => 
            array (
                'id' => 265,
                'name' => 'announcement.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:16:52',
                'updated_at' => '2022-03-09 12:16:52',
            ),
            263 => 
            array (
                'id' => 266,
                'name' => 'announcement.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:16:52',
                'updated_at' => '2022-03-09 12:16:52',
            ),
            264 => 
            array (
                'id' => 267,
                'name' => 'announcement.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:16:52',
                'updated_at' => '2022-03-09 12:16:52',
            ),
            265 => 
            array (
                'id' => 268,
                'name' => 'quiz-topic.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:20:22',
                'updated_at' => '2022-03-09 12:20:22',
            ),
            266 => 
            array (
                'id' => 269,
                'name' => 'quiz-topic.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:20:22',
                'updated_at' => '2022-03-09 12:20:22',
            ),
            267 => 
            array (
                'id' => 270,
                'name' => 'quiz-topic.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:20:22',
                'updated_at' => '2022-03-09 12:20:22',
            ),
            268 => 
            array (
                'id' => 271,
                'name' => 'quiz-topic.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:20:22',
                'updated_at' => '2022-03-09 12:20:22',
            ),
            269 => 
            array (
                'id' => 272,
                'name' => 'previous-paper.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:20:55',
                'updated_at' => '2022-03-09 12:20:55',
            ),
            270 => 
            array (
                'id' => 273,
                'name' => 'previous-paper.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:20:56',
                'updated_at' => '2022-03-09 12:20:56',
            ),
            271 => 
            array (
                'id' => 274,
                'name' => 'previous-paper.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:20:56',
                'updated_at' => '2022-03-09 12:20:56',
            ),
            272 => 
            array (
                'id' => 275,
                'name' => 'previous-paper.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:20:56',
                'updated_at' => '2022-03-09 12:20:56',
            ),
            273 => 
            array (
                'id' => 276,
                'name' => 'courses-language.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:22:06',
                'updated_at' => '2022-03-09 12:22:06',
            ),
            274 => 
            array (
                'id' => 277,
                'name' => 'courses-language.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:22:07',
                'updated_at' => '2022-03-09 12:22:07',
            ),
            275 => 
            array (
                'id' => 278,
                'name' => 'courses-language.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:22:07',
                'updated_at' => '2022-03-09 12:22:07',
            ),
            276 => 
            array (
                'id' => 279,
                'name' => 'courses-language.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:22:07',
                'updated_at' => '2022-03-09 12:22:07',
            ),
            277 => 
            array (
                'id' => 280,
                'name' => 'featured-courses.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:23:10',
                'updated_at' => '2022-03-09 12:23:10',
            ),
            278 => 
            array (
                'id' => 281,
                'name' => 'featured-courses.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:23:10',
                'updated_at' => '2022-03-09 12:23:10',
            ),
            279 => 
            array (
                'id' => 282,
                'name' => 'featured-courses.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:23:10',
                'updated_at' => '2022-03-09 12:23:10',
            ),
            280 => 
            array (
                'id' => 283,
                'name' => 'featured-courses.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:23:10',
                'updated_at' => '2022-03-09 12:23:10',
            ),
            281 => 
            array (
                'id' => 284,
                'name' => 'role.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:25:00',
                'updated_at' => '2022-03-09 12:25:00',
            ),
            282 => 
            array (
                'id' => 285,
                'name' => 'role.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:25:00',
                'updated_at' => '2022-03-09 12:25:00',
            ),
            283 => 
            array (
                'id' => 286,
                'name' => 'role.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:25:00',
                'updated_at' => '2022-03-09 12:25:00',
            ),
            284 => 
            array (
                'id' => 287,
                'name' => 'role.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-09 12:25:00',
                'updated_at' => '2022-03-09 12:25:00',
            ),
            285 => 
            array (
                'id' => 288,
                'name' => 'meetings.zoom-meetings.settings',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 09:27:08',
                'updated_at' => '2022-03-10 09:27:08',
            ),
            286 => 
            array (
                'id' => 289,
                'name' => 'meetings.zoom-meetings.dashboard',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 09:27:22',
                'updated_at' => '2022-03-10 09:27:22',
            ),
            287 => 
            array (
                'id' => 290,
                'name' => 'meetings.big-blue.settings',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 09:56:00',
                'updated_at' => '2022-03-10 09:56:00',
            ),
            288 => 
            array (
                'id' => 291,
                'name' => 'meetings.big-blue.list-meetings',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 09:59:09',
                'updated_at' => '2022-03-10 09:59:09',
            ),
            289 => 
            array (
                'id' => 292,
                'name' => 'meetings.big-blue.recorded',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 10:00:28',
                'updated_at' => '2022-03-10 10:00:28',
            ),
            290 => 
            array (
                'id' => 293,
                'name' => 'meetings.google-meet.settings',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 10:12:07',
                'updated_at' => '2022-03-10 10:12:07',
            ),
            291 => 
            array (
                'id' => 294,
                'name' => 'meetings.google-meet.dashboard',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 10:13:00',
                'updated_at' => '2022-03-10 10:13:00',
            ),
            292 => 
            array (
                'id' => 295,
                'name' => 'meetings.google-meet.all-meetings',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 10:14:36',
                'updated_at' => '2022-03-10 10:14:36',
            ),
            293 => 
            array (
                'id' => 296,
                'name' => 'meetings.jitsi-meet.dashboard',
                'guard_name' => 'web',
                'created_at' => '2022-03-10 10:24:37',
                'updated_at' => '2022-03-10 10:24:37',
            ),
            294 => 
            array (
                'id' => 297,
                'name' => 'Allinstructor.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 09:38:46',
                'updated_at' => '2022-03-14 09:38:46',
            ),
            295 => 
            array (
                'id' => 298,
                'name' => 'Allinstructor.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 09:38:46',
                'updated_at' => '2022-03-14 09:38:46',
            ),
            296 => 
            array (
                'id' => 299,
                'name' => 'Allinstructor.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 09:38:46',
                'updated_at' => '2022-03-14 09:38:46',
            ),
            297 => 
            array (
                'id' => 300,
                'name' => 'Allinstructor.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 09:38:46',
                'updated_at' => '2022-03-14 09:38:46',
            ),
            298 => 
            array (
                'id' => 301,
                'name' => 'Alluser.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 10:39:10',
                'updated_at' => '2022-03-14 10:39:10',
            ),
            299 => 
            array (
                'id' => 302,
                'name' => 'Alluser.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 10:39:10',
                'updated_at' => '2022-03-14 10:39:10',
            ),
            300 => 
            array (
                'id' => 303,
                'name' => 'Alluser.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 10:39:10',
                'updated_at' => '2022-03-14 10:39:10',
            ),
            301 => 
            array (
                'id' => 304,
                'name' => 'Alluser.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 10:39:10',
                'updated_at' => '2022-03-14 10:39:10',
            ),
            302 => 
            array (
                'id' => 305,
                'name' => 'answer.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 13:05:43',
                'updated_at' => '2022-03-14 13:05:43',
            ),
            303 => 
            array (
                'id' => 306,
                'name' => 'answer.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 13:05:44',
                'updated_at' => '2022-03-14 13:05:44',
            ),
            304 => 
            array (
                'id' => 307,
                'name' => 'answer.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 13:05:44',
                'updated_at' => '2022-03-14 13:05:44',
            ),
            305 => 
            array (
                'id' => 308,
                'name' => 'answer.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-14 13:05:44',
                'updated_at' => '2022-03-14 13:05:44',
            ),
            306 => 
            array (
                'id' => 309,
                'name' => 'instructor-plan-subscription.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-15 08:48:45',
                'updated_at' => '2022-03-15 08:48:45',
            ),
            307 => 
            array (
                'id' => 310,
                'name' => 'instructor-plan-subscription.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-15 08:48:45',
                'updated_at' => '2022-03-15 08:48:45',
            ),
            308 => 
            array (
                'id' => 311,
                'name' => 'instructor-plan-subscription.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-15 08:48:45',
                'updated_at' => '2022-03-15 08:48:45',
            ),
            309 => 
            array (
                'id' => 312,
                'name' => 'instructor-plan-subscription.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-15 08:48:45',
                'updated_at' => '2022-03-15 08:48:45',
            ),
            310 => 
            array (
                'id' => 313,
                'name' => 'requestinvole.manage',
                'guard_name' => 'web',
                'created_at' => '2022-03-15 11:01:57',
                'updated_at' => '2022-03-15 11:01:57',
            ),
            311 => 
            array (
                'id' => 314,
                'name' => 'involvement.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-16 05:23:50',
                'updated_at' => '2022-03-16 05:23:50',
            ),
            312 => 
            array (
                'id' => 315,
                'name' => 'involvement.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-16 05:23:50',
                'updated_at' => '2022-03-16 05:23:50',
            ),
            313 => 
            array (
                'id' => 316,
                'name' => 'involvement.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-16 05:23:50',
                'updated_at' => '2022-03-16 05:23:50',
            ),
            314 => 
            array (
                'id' => 317,
                'name' => 'involvement.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-16 05:23:50',
                'updated_at' => '2022-03-16 05:23:50',
            ),
            315 => 
            array (
                'id' => 318,
                'name' => 'instructorrequest.view',
                'guard_name' => 'web',
                'created_at' => '2022-03-16 05:38:11',
                'updated_at' => '2022-03-16 05:38:11',
            ),
            316 => 
            array (
                'id' => 319,
                'name' => 'instructorrequest.create',
                'guard_name' => 'web',
                'created_at' => '2022-03-16 05:38:11',
                'updated_at' => '2022-03-16 05:38:11',
            ),
            317 => 
            array (
                'id' => 320,
                'name' => 'instructorrequest.edit',
                'guard_name' => 'web',
                'created_at' => '2022-03-16 05:38:12',
                'updated_at' => '2022-03-16 05:38:12',
            ),
            318 => 
            array (
                'id' => 321,
                'name' => 'instructorrequest.delete',
                'guard_name' => 'web',
                'created_at' => '2022-03-16 05:38:12',
                'updated_at' => '2022-03-16 05:38:12',
            ),
            319 => 
            array (
                'id' => 322,
                'name' => 'notice.view',
                'guard_name' => 'web',
                'created_at' => '2024-07-25 10:56:18',
                'updated_at' => '2024-07-25 10:56:18',
            ),
            320 => 
            array (
                'id' => 323,
                'name' => 'notice.create',
                'guard_name' => 'web',
                'created_at' => '2024-07-25 10:56:30',
                'updated_at' => '2024-07-25 10:56:30',
            ),
            321 => 
            array (
                'id' => 324,
                'name' => 'notice.edit',
                'guard_name' => 'web',
                'created_at' => '2024-07-25 10:56:43',
                'updated_at' => '2024-07-25 10:56:43',
            ),
            322 => 
            array (
                'id' => 325,
                'name' => 'notice.delete',
                'guard_name' => 'web',
                'created_at' => '2024-07-25 10:56:56',
                'updated_at' => '2024-07-25 10:56:56',
            ),
            323 => 
            array (
                'id' => 326,
                'name' => 'questionbook.view',
                'guard_name' => 'web',
                'created_at' => '2024-07-26 09:56:59',
                'updated_at' => '2024-07-26 09:56:59',
            ),
            324 => 
            array (
                'id' => 327,
                'name' => 'questionbook.create',
                'guard_name' => 'web',
                'created_at' => '2024-07-26 09:57:12',
                'updated_at' => '2024-07-26 09:57:12',
            ),
            325 => 
            array (
                'id' => 328,
                'name' => 'questionbook.edit',
                'guard_name' => 'web',
                'created_at' => '2024-07-26 09:57:23',
                'updated_at' => '2024-07-26 09:57:23',
            ),
            326 => 
            array (
                'id' => 330,
                'name' => 'questionbook.delete',
                'guard_name' => 'web',
                'created_at' => '2024-07-26 09:58:34',
                'updated_at' => '2024-07-26 09:58:34',
            ),
            327 => 
            array (
                'id' => 331,
                'name' => 'Alladmin.view',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 06:57:52',
                'updated_at' => '2024-10-02 06:57:52',
            ),
            328 => 
            array (
                'id' => 332,
                'name' => 'Alladmin.create',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 06:58:01',
                'updated_at' => '2024-10-02 06:58:01',
            ),
            329 => 
            array (
                'id' => 333,
                'name' => 'Alladmin.edit',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 06:58:05',
                'updated_at' => '2024-10-02 06:58:05',
            ),
            330 => 
            array (
                'id' => 334,
                'name' => 'Alladmin.delete',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 06:58:10',
                'updated_at' => '2024-10-02 06:58:10',
            ),
            331 => 
            array (
                'id' => 335,
                'name' => 'alumini.view',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 08:33:01',
                'updated_at' => '2024-10-02 08:33:01',
            ),
            332 => 
            array (
                'id' => 336,
                'name' => 'alumini.create',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 08:33:14',
                'updated_at' => '2024-10-02 08:33:14',
            ),
            333 => 
            array (
                'id' => 337,
                'name' => 'alumini.edit',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 08:33:22',
                'updated_at' => '2024-10-02 08:33:22',
            ),
            334 => 
            array (
                'id' => 338,
                'name' => 'alumini.delete',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 08:33:30',
                'updated_at' => '2024-10-02 08:33:30',
            ),
            335 => 
            array (
                'id' => 339,
                'name' => 'mobilesetting.manage',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:21:27',
                'updated_at' => '2024-10-02 10:21:27',
            ),
            336 => 
            array (
                'id' => 340,
                'name' => 'downloadqr.manage',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:24:01',
                'updated_at' => '2024-10-02 10:24:01',
            ),
            337 => 
            array (
                'id' => 341,
                'name' => 'serviceSetting.manage',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:27:22',
                'updated_at' => '2024-10-02 10:27:22',
            ),
            338 => 
            array (
                'id' => 342,
                'name' => 'admin.searvice.view',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:29:45',
                'updated_at' => '2024-10-02 10:29:45',
            ),
            339 => 
            array (
                'id' => 343,
                'name' => 'admin.searvice.create',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:29:55',
                'updated_at' => '2024-10-02 10:29:55',
            ),
            340 => 
            array (
                'id' => 344,
                'name' => 'admin.searvice.edit',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:30:12',
                'updated_at' => '2024-10-02 10:30:12',
            ),
            341 => 
            array (
                'id' => 345,
                'name' => 'admin.searvice.delete',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:30:18',
                'updated_at' => '2024-10-02 10:30:18',
            ),
            342 => 
            array (
                'id' => 346,
                'name' => 'admin.features.view',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:32:10',
                'updated_at' => '2024-10-02 10:32:10',
            ),
            343 => 
            array (
                'id' => 347,
                'name' => 'admin.features.create',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:32:17',
                'updated_at' => '2024-10-02 10:32:17',
            ),
            344 => 
            array (
                'id' => 348,
                'name' => 'admin.features.edit',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:32:28',
                'updated_at' => '2024-10-02 10:32:28',
            ),
            345 => 
            array (
                'id' => 349,
                'name' => 'admin.features.delete',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:32:37',
                'updated_at' => '2024-10-02 10:32:37',
            ),
            346 => 
            array (
                'id' => 350,
                'name' => 'admin.costomisation.manage',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 10:36:23',
                'updated_at' => '2024-10-02 10:36:23',
            ),
            347 => 
            array (
                'id' => 351,
                'name' => 'support.manage',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 11:05:35',
                'updated_at' => '2024-10-02 11:05:35',
            ),
            348 => 
            array (
                'id' => 352,
                'name' => 'support.create',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 11:06:10',
                'updated_at' => '2024-10-02 11:06:10',
            ),
            349 => 
            array (
                'id' => 353,
                'name' => 'support.edit',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 11:06:26',
                'updated_at' => '2024-10-02 11:06:26',
            ),
            350 => 
            array (
                'id' => 354,
                'name' => 'support.delete',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 11:06:37',
                'updated_at' => '2024-10-02 11:06:37',
            ),
            351 => 
            array (
                'id' => 355,
                'name' => 'support_admin.manage',
                'guard_name' => 'web',
                'created_at' => '2024-10-02 11:06:53',
                'updated_at' => '2024-10-02 11:06:53',
            ),
        ));
        
        
    }
}