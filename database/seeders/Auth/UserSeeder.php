<?php

namespace Database\Seeders\Auth;

use App\Models\Gallery;
use App\Models\Goal;
use App\Models\Photo;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $superAdmin = Role::where('slug', 'super-administrator')->firstOrFail();
        $admin = Role::where('slug', 'administrator')->firstOrFail();
        $customer = Role::where('slug', 'customer')->firstOrFail();

        $user1 = new User();
        $user1->name = 'Gulácsi András';
        $user1->email = 'gulandras90@gmail.com';
        $user1->password = bcrypt('D3#^b&&q94k02z');
        $user1->enable_2fa = 1;
        $user1->handle = Str::slug($user1->name).'-'.bin2hex(random_bytes(5));
        $user1->role()->associate($superAdmin);
        $user1->save();

        $this->generateGoals($user1);
        $this->generateUserGalleriesWithTags($user1);

        $user2 = new User();
        $user2->name = 'John Doe';
        $user2->email = 'john@doe.com';
        $user2->password = bcrypt('password');
        $user2->handle = Str::slug($user2->name).'-'.bin2hex(random_bytes(5));
        $user2->save();
        $user2->role()->associate($admin);

        $user3 = new User();
        $user3->name = 'Finn Gabika';
        $user3->email = 'finn@gabika.com';
        $user3->password = bcrypt('password');
        $user3->handle = Str::slug($user3->name).'-'.bin2hex(random_bytes(5));
        $user3->save();
        $user3->role()->associate($customer);

        $this->generateGoals($user3);
        $this->generateUserGalleriesWithTags($user3);


    }


    /**
     * @param  User  $user
     * @return void
     */
    private function generateGoals(User $user)
    {
        Goal::factory(rand(6, 16))->create([
            'user_id' => $user->id
        ]);
    }


    /**
     * @param  User  $user
     * @param  Gallery  $gallery
     * @return void
     */
    private function generatePhotosAndAssignToGallery(User $user, Gallery $gallery): void
    {
        Photo::factory(rand(6, 16))->create([
            'user_id' => $user->id,
            'gallery_id' => $gallery->id
        ]);
    }


    /**
     * @param  User  $user
     * @return void
     */
    private function generateUserGalleriesWithTags(User $user): void
    {
        // Also create galleries for each user created
        Gallery::factory(rand(8, 10))->create([
            'user_id' => $user->id
        ])
            ->each(function ($gallery) use ($user) {

                Tag::factory(rand(2, 5))->create([
                    'user_id' => $user->id,
                ]);
                $tagIdsToAssign = $this->getTagIdsArray();
                $this->assignTagsToGalleries($tagIdsToAssign, $gallery);

                $this->generatePhotosAndAssignToGallery($user, $gallery);

            });
    }


    /**
     * Get array of shuffled, random number of ids from tags collection
     *
     * @return array
     */
    private function getTagIdsArray(): array
    {
        $tags = Tag::all();
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = intval($tag->id);
        }
        shuffle($tagIds);
        return array_slice($tagIds, 0, rand(0, count($tagIds)));
    }


    /**
     * Fill up galleries_tags table
     *
     * @param  array  $tagIdsToAssign
     * @param  Gallery  $gallery
     * @return void
     */
    private function assignTagsToGalleries(array $tagIdsToAssign, Gallery $gallery): void
    {
        foreach ($tagIdsToAssign as $tagId) {
            DB::table('galleries_tags')->insert(
                [
                    'gallery_id' => intval($gallery->id),
                    'tag_id' => intval($tagId),
                ]
            );
        }
    }
}
