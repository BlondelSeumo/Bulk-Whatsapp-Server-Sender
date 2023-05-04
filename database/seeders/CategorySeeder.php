<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     $categories = array(
      array('id' => '1','title' => '#','slug' => '/uploads/23/03/16781015652CQnP1QNhw2T4te7n4J2.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:19:25','updated_at' => '2023-03-06 11:19:25'),
      array('id' => '2','title' => '#','slug' => '/uploads/23/03/1678101574iv7f5NuUi7wXfkq4DQwf.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:19:34','updated_at' => '2023-03-06 11:19:34'),
      array('id' => '3','title' => '#','slug' => '/uploads/23/03/1678101584RYE53fStsc5Rbnwm1Acq.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:19:44','updated_at' => '2023-03-06 11:19:44'),
      array('id' => '4','title' => '#','slug' => '/uploads/23/03/1678101592TSj8SeYx7JZM0dhRYq1k.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:19:52','updated_at' => '2023-03-06 11:19:52'),
      array('id' => '5','title' => '#','slug' => '/uploads/23/03/1678101601r2uMoEBkUc9cN4n60XTn.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 11:20:01','updated_at' => '2023-03-06 11:20:01'),
      array('id' => '6','title' => 'Chatbot','slug' => 'chatbot','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:35:06','updated_at' => '2023-03-06 18:35:06'),
      array('id' => '7','title' => 'Target marketing','slug' => 'target-marketing','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:35:30','updated_at' => '2023-03-06 18:35:30'),
      array('id' => '8','title' => 'Button message','slug' => 'button-message','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:36:44','updated_at' => '2023-03-06 18:36:44'),
      array('id' => '9','title' => 'Template message','slug' => 'template-message','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:36:50','updated_at' => '2023-03-06 18:36:50'),
      array('id' => '10','title' => 'Location message','slug' => 'location-message','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:37:56','updated_at' => '2023-03-06 18:37:56'),
      array('id' => '11','title' => 'support','slug' => 'support','type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:38:24','updated_at' => '2023-03-06 18:38:24'),
      array('id' => '12','title' => 'marketing','slug' => 'marketing','type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:38:46','updated_at' => '2023-03-06 18:38:46'),
      array('id' => '13','title' => 'whatsapp','slug' => 'whatsapp','type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:39:05','updated_at' => '2023-03-06 18:39:05'),
      array('id' => '14','title' => 'chatbot','slug' => 'chatbot','type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:39:16','updated_at' => '2023-03-06 18:39:16'),
      array('id' => '16','title' => '#','slug' => '/uploads/23/04/1681069463TyzbAs8krJWkdmfle2AK.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'integration','created_at' => '2023-04-09 19:44:23','updated_at' => '2023-04-09 19:44:23'),
      array('id' => '17','title' => '#','slug' => '/uploads/23/04/1681069481dhzTeKTgyImXGO6uxfKS.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'integration','created_at' => '2023-04-09 19:44:41','updated_at' => '2023-04-09 19:44:41'),
      array('id' => '18','title' => '#','slug' => '/uploads/23/04/1681069492WKuK8M4N4F0zCq5rTLrm.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'integration','created_at' => '2023-04-09 19:44:52','updated_at' => '2023-04-09 19:44:52'),
      array('id' => '19','title' => '#','slug' => '/uploads/23/04/16810695031BJ8EGeeQRaQsqsMAAQL.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'integration','created_at' => '2023-04-09 19:45:03','updated_at' => '2023-04-09 19:45:03'),
      array('id' => '20','title' => '#','slug' => '/uploads/23/04/1681069512lsGeQfcBynLLEfPEDmEy.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'integration','created_at' => '2023-04-09 19:45:12','updated_at' => '2023-04-09 19:45:12'),
      array('id' => '21','title' => '#','slug' => '/uploads/23/04/1681069522nLsyBhcnY7Im1u9MZXMl.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'integration','created_at' => '2023-04-09 19:45:22','updated_at' => '2023-04-09 19:45:22'),
      array('id' => '22','title' => '#','slug' => '/uploads/23/04/1681069535bhMiLvhKrd6rBnOvm8LC.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'integration','created_at' => '2023-04-09 19:45:35','updated_at' => '2023-04-09 19:45:35')
    );

        Category::insert($categories);

    }
}
