<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            {{ __('Update Post') }}
            <a href={{ route('posts.index') }}><span class="text-lg text-white bg-red-800 rounded p-2">Back</span></a>
        </h2>
    </x-slot>


    <section>
       
    
        <div class="max-w-7xl px-6 py-12 mx-auto  rounded mt-5 bg-white">

    
            <form method="POST" action="{{ url('posts/'.$post->id) }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT') <!-- Method override for PUT request -->
            
                <div>
                    <x-input-label for="title" :value="__('Title')" /> <!-- Title label -->
                    <x-text-input 
                        id="title" 
                        name="title" 
                        type="text" 
                        :value="old('title', $post->title)" 
                        class="mt-1 py-2 border block w-full"  
                        required  
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" /> <!-- Validation errors for title -->
                </div>
            
                <div>
                    <x-input-label for="content" :value="__('Content')" /> <!-- Content label -->
                    <x-text-input 
                        id="content" 
                        name="content" 
                        type="text" 
                        :value="old('content', $post->content)" 
                        class="mt-1 border p-2 block w-full"   
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('content')" /> <!-- Validation errors for content -->
                </div>
            
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button> <!-- Save button -->
                </div>
            </form>

        </div>
    </section>
    




</x-app-layout>