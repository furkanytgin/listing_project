<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    #Show all listings
    public function index(){
        $listings = Listing::latest()->filter(request(['tag', 'search']))->paginate(4);
        return view('listings.index', compact('listings'));
    }

    #Show single listing
    public function show(Listing $listing){

        return view('listings.show', compact('listing'));
    }

    #create listing
    public function create(){

        return view('listings.create');
    }

    public function store(Request $request){

        $formField = $request->validate([
            'title'=> 'required',
            'company'=> ['required'],
            'location'=> 'required',
            'website'=> 'required',
            'email'=> ['required', 'email'],
            'tags'=> 'required',
            'description'=> 'required',
            'logo' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:12048']
        ]);
        if($request->hasFile('logo')){

            $fileTemp = $request->file('logo');

            if($fileTemp->isValid()){
                $fileExtension = $fileTemp->getClientOriginalExtension();
                $fileName = Str::random(4). '.'. $fileExtension;
                $path = $fileTemp->storeAs(
                    'public/logos', $fileName
                );
                $formField['logo'] = $path;

            }
        }
        $formField['user_id'] = auth()->id();


        Listing::create($formField);

        return redirect('/')->with('message', 'Listing created succesfully!');
    }

    public function edit(Listing $listing){

        return view('listings.edit', compact('listing'));
    }

    public function update(Request $request, Listing $listing){

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action!');
        }

        $formField = $request->validate([
            'title'=> 'required',
            'company'=> ['required'],
            'location'=> 'required',
            'website'=> 'required',
            'email'=> ['required', 'email'],
            'tags'=> 'required',
            'description'=> 'required',
            'logo' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:12048']
        ]);
        if($request->hasFile('logo')){

            $fileTemp = $request->file('logo');

            if($fileTemp->isValid()){
                $fileExtension = $fileTemp->getClientOriginalExtension();
                $fileName = Str::random(4). '.'. $fileExtension;
                $path = $fileTemp->storeAs(
                    'public/logos', $fileName
                );
                $formField['logo'] = $path;

            }
        }
        if($listing->logo != null){
            Storage::delete($listing->logo);
        }



        $listing->update($formField);

        return redirect('/')->with('message', 'Listing update succesfully!');
    }

    public function delete(Listing $listing){

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action!');
        }
        $listing->delete();
        if($listing->logo != null){
            Storage::delete($listing->logo);
        }

        return back()->with('message', 'Listing deleted succesfully');
    }

    public function manage(){

        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
