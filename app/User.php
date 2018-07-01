<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Storage;

class User extends Authenticatable
{
    use Notifiable;

    const IS_NORMAL = 0;
    const IS_ADMIN = 1;

    const IS_ACTIVE = 0;
    const IS_BANNED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new self;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $user->fill($fields);       
        $user->save();
    }

    public function remove()
    {
        $this->removeAvatar();

        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if($image == null) {
            return;
        }
        
        $this->removeAvatar();

        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->avatar = $filename;
        $this->save();
    }

    public function getAvatar()
    {
        if($this->avatar == null) {
            return 'img/no_avatar.png';
        }

        return '/uploads/' . $this->avatar;
    }

    public function makeNormal()
    {
        $this->isAdmin = User::IS_NORMAL;
        $this->save();
    }

    public function makeAdmin()
    {
        $this->isAdmin = User::IS_ADMIN;
        $this->save();
    }

    public function toggleAdmin($value)
    {
        if($value == null) {
            return $this->makeNormal();
        }

        return $this->makeAdmin();
    }

    public function unban()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    public function toggleBan($value)
    {
        if($value == null) {
            return $this->unban();
        }

        return $this->ban();
    }

    public function generatePassword($password)
    {
        if($password != null) {
            $user->password = bcrypt($fields['password']);
            $this->save();
        }
    }

    public function removeAvatar()
    {
        if($this->avatar != null) {
            Storage::delete('uploads/' . $this->avatar);
        }        
    }
}
