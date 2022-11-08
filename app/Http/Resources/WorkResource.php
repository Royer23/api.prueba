<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->image){
            return [
                'id' => $this->id,
                'name' => $this->name,
                'status'=>$this->status == 1 ? 'No Realizado' : 'Realizado',
                'url_image'=>$this->image->url,
                'created_at'=>  date_format($this->created_at,"d/m/Y"),
                
                'user' => UserResource::make($this->whenLoaded('user')),
                
            ];
                    
        }else{
            return [
                'id' => $this->id,
                'name' => $this->name,
                'status'=>$this->status == 1 ? 'No Realizado' : 'Realizado',
                'created_at'=>  date_format($this->created_at,"d/m/Y"),
                'url_image'=>'',
                'user' => UserResource::make($this->whenLoaded('user')),
                
            ];
    
        }
    }
}
