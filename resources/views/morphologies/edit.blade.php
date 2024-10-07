<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Morphology') }}
        </h2>
    </x-slot>

    @if($morphology !== null)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('morphologies.partials.update-morphologies-form')
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-body bg-light">
                            <div class="mb-3">
                                <h4>Aucune morphologie n'a été enregistrée</h4>
                                <!-- <a href="route('morphologies.create')">
                                    <i class="fa-regular fa-square-plus fa-2xl"></i>
                                <a> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
