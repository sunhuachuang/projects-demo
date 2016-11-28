<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Image;

class Ticket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'number', 'price', 'image'
    ];

    /**
     * Get all of the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * save ticket to db.
     */
    public function customSave(Ticket $ticket, $request)
    {
        $ticket->name   = $request->name;
        $ticket->number = $request->number;
        $ticket->price  = $request->price;

        if($request->file('image')) {
            $oldImage = $ticket->image;
            $image = $request->file('image');
            $imageName = time().$image->getClientOriginalName();
            $ticket->image  = $imageName;
            $path = public_path('storage/ticket_images/' . $imageName);
            //save to Storage
            Image::make($request->file('image'))->resize(220, 180)->save($path);
            if($oldImage) {
                Storage::delete('public/ticket_images/'. $oldImage);
            }
        }
        $ticket->save();
    }

    /**
     * save ticket to db.
     */
    public function customDelete(Ticket $ticket)
    {
        $oldImage = $ticket->image;
        $ticket->delete();
        if($oldImage) {
            Storage::delete('public/ticket_images/'. $oldImage);
        }
    }
}
