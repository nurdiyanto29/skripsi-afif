<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Attachment extends Model
{
    use HasFactory;

    protected $table = 'system_file';

    protected $guarded = ['disk_name'];

    public static $imageExtensions = ['jpg', 'jpeg', 'png', 'gif','bmp'];

    /**
     * @var array Hidden fields from array/json access
     */
    protected $hidden = ['attachable_type', 'attachable_id', 'is_public'];

    /**
     * @var array Add fields to array/json access
     */
    protected $appends = ['path'];
    // protected $appends = ['path', 'extension'];


    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function processFile($file, $field = [])
    {
        if(!$file) return null;

        $date = date('Y-m-d H:i:s');
        $folder = files_folder($date);
        $fileName = uniqid().'.'.$file->getClientOriginalExtension();
                
        $field +=[
            'created_at' => $date,
            'updated_at' => $date,
            'created_by' => Auth::id(),
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'content_type' => $file->getClientMimeType()
        ];
        
        $upload = null;
        try {
            $upload = $file->move(public_path($folder), $fileName);
        } catch (\Exception $th) {
            $upload = $file->store($folder, 'real_public');
            $names = explode('/',$upload);
            $fileName = end($names);
        } catch (\Exception $th) {
            return null;
        }


        if(!$upload) return null;

        $this->disk_name = $fileName;
        $this->fill($field);

        return $this;
    }

    function getPathAttribute(){
        return files_folder($this->created_at,$this->disk_name);
    }

    public function getFileUnitAttribute()
    {
        $size = $this->file_size;
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');

        for ($i = 0; $size > 1024; $i++) { $size /= 1024; }

        return round($size, 2).$units[$i];
    }
 
   
    protected static function booted(): void
    {

        static::deleting(function (Attachment $e) {
            @unlink(public_path($e->path));
        });
    }

}
