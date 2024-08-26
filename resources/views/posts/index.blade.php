<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            {{ __('Posts') }}
            <a href="posts/create"><span class="text-lg text-white bg-green-800 rounded p-2">Create Post</span></a>
        </h2>
    </x-slot>


    <section>
        <div class="max-w-7xl px-6 py-12 mx-auto  rounded mt-5 bg-white">

        <div class="overflow-x-scroll lg:overflow-x-hidden">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom">
                  <tr>
                    <th class="px-6 py-3 pl-2 noto-sans-arabic-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-sm border-b-solid tracking-none whitespace-nowrap text-black opacity-70">Title</th>
                    <th class="px-6 py-3 pl-2 noto-sans-arabic-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-sm border-b-solid tracking-none whitespace-nowrap text-black opacity-70">Created By</th>
                    <th class="px-6 py-3 noto-sans-arabic-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-sm border-b-solid tracking-none whitespace-nowrap text-black opacity-70">Comments Count</th>
                    <th class="px-6 py-3 noto-sans-arabic-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-sm border-b-solid tracking-none whitespace-nowrap text-black opacity-70">CREATED AT</th>
                    <th class="px-6 py-3 noto-sans-arabic-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-sm border-b-solid tracking-none whitespace-nowrap text-black opacity-70">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($posts as $post )
        
                  <tr>
                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                      <span class="text-xs noto-sans-arabic-bold leading-tight text-slate-400">{{ $post->title }}</span>
                    </td>

                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                      <span class="text-xs noto-sans-arabic-bold leading-tight text-slate-400">{{ $post->user->name }}</span>
                    </td>

                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                        <span class="text-xs noto-sans-arabic-bold leading-tight text-slate-400">{{ $post->comments->count() }}</span>
                      </td>
        
                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                      <span class="text-xs noto-sans-arabic-bold leading-tight text-slate-400">{{ $post->created_at->format('Y-m-d') }}</span>
                    </td>
        
        
                      <td class="align-center bg-transparent border-b  shadow-transparent">
                        <div class=" flex gap-5 w-full justify-center">
                                <a href="{{'/posts/'.$post->id.'/edit'}}" class="text-sm   leading-tight bg-yellow-600 text-white hover:opacity-70 px-3 py-1 rounded-lg duration-300 noto-sans-arabic-bold hover:-translate-y-1">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                
                                    <button type="submit" class="text-sm leading-tight bg-cyan-400 text-white hover:opacity-70 px-3 py-1 rounded-lg duration-300 noto-sans-arabic-bold hover:-translate-y-1">
                                        Delete
                                    </button>
                                </form>
                        </div>
        
                      </td>
        
                  </tr>
                  @empty
                  <tr>
                      <td colspan="8" class="text-center p-4 text-black ">Not Data Found</td>
                  </tr>
                @endforelse
        
                </tbody>
              </table>
        </div>
        
        </div>
        
    </section>
    




</x-app-layout>