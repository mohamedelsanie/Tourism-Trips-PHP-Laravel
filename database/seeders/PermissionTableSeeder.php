<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            // Admins Permissions
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'admin-forcedelete',
            // Users Permissions
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-forcedelete',
            // Permissions Permissions
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            // News Permissions
            'news-list',
            'news-create',
            'news-edit',
            'news-delete',
            'news-forcedelete',
            // News Categories Permissions
            'news-categories-list',
            'news-categories-create',
            'news-categories-edit',
            'news-categories-delete',
            'news-categories-forcedelete',
            // News Comments Permissions
            'news-comments-list',
            'news-comments-create',
            'news-comments-edit',
            'news-comments-delete',
            'news-comments-forcedelete',
            // Media Permissions
            'media-list',
            'media-create',
            'media-edit',
            'media-delete',
            'media-forcedelete',
            // pages Permissions
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',
            'page-forcedelete',
            // Roles Permissions
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            // Settings Permissions
            'setting-edit',
            // Menus Permissions
            'menu-edit',
            // News Categories Permissions
            'postcategory-list',
            'postcategory-create',
            'postcategory-edit',
            'postcategory-delete',
            'postcategory-forcedelete',
            // News Comments Permissions
            'postcomment-list',
            'postcomment-create',
            'postcomment-edit',
            'postcomment-delete',
            'postcomment-forcedelete',
            // News Tags Permissions
            'posttag-list',
            'posttag-create',
            'posttag-edit',
            'posttag-delete',
            // Videos Permissions
            'video-list',
            'video-create',
            'video-edit',
            'video-delete',
            'video-forcedelete',
            // Videos Comments Permissions
            'videocomment-list',
            'videocomment-create',
            'videocomment-edit',
            'videocomment-delete',
            'videocomment-forcedelete',
            // Images Permissions
            'image-list',
            'image-create',
            'image-edit',
            'image-delete',
            'image-forcedelete',
            // Images Comments Permissions
            'imagecomment-list',
            'imagecomment-create',
            'imagecomment-edit',
            'imagecomment-delete',
            'imagecomment-forcedelete',
            // tours Permissions
            'tour-list',
            'tour-create',
            'tour-edit',
            'tour-delete',
            'tour-forcedelete',
            // tours Categories Permissions
            'tourcategory-list',
            'tourcategory-create',
            'tourcategory-edit',
            'tourcategory-delete',
            'tourcategory-forcedelete',
            // tours Comments Permissions
            'tourcomment-list',
            'tourcomment-create',
            'tourcomment-edit',
            'tourcomment-delete',
            'tourcomment-forcedelete',
            // Orders Permissions
            'order-list',
            'order-create',
            'order-edit',
            'order-delete',
            'order-forcedelete',
            // Orders Permissions
            'contact-list',
            'contact-create',
            'contact-edit',
            'contact-delete',
            'contact-forcedelete',
            // Offers Permissions
            'offer-list',
            'offer-create',
            'offer-edit',
            'offer-delete',
            'offer-forcedelete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission,'guard_name' => 'admin']);
        }
    }
}
