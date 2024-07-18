<div>



    <div x-data="{ selectedTab: 'tab1' }" class="container mx-auto m-4">
        <ul class="flex flex-wrap gap-4 border-b border-gray-200 bg-slate-200 p-4 rounded-md">
            <li class="flex-1 text-center border-b-2 hover:border-blue-500"
                :class="{ 'border-blue-500': selectedTab === 'tab1' }">
                <a href="#" @click.prevent="selectedTab = 'tab1'">Information</a>
            </li>
            <li class="flex-1 text-center border-b-2 hover:border-blue-500"
                :class="{ 'border-blue-500': selectedTab === 'tab2' }">
                <a href="#" @click.prevent="selectedTab = 'tab2'">Password Change</a>
            </li>
            <li class="flex-1 text-center border-b-2 hover:border-blue-500"
                :class="{ 'border-blue-500': selectedTab === 'tab3' }">
                <a class="bg-rose-500 leading-6" href="#" @click.prevent="selectedTab = 'tab3'">Delete
                    Account</a>
            </li>
        </ul>
        <div class="mt-4 bg-slate-300 p-6 rounded-md shadow-md ">
            <div x-show="selectedTab === 'tab1'">Content for Tab 1</div>
            <div x-show="selectedTab === 'tab2'">Content for Tab 2</div>
            <div x-show="selectedTab === 'tab3'">Content for Tab 3</div>
        </div>
    </div>



    <div>
        <div class="grid w-full  bg-slate-300">
            {{-- <ul class="flex flex-row gap-2 w-full  bg-slate-600 justify-between px-4 text-white">
                <li>Information</li>
                <li>Password Chane</li>
                <li>Delete Account</li>
            </ul> --}}

            <ul class="flex flex-row gap-2 w-full bg-slate-600 justify-between px-4 text-white">
                <li class="flex-1 text-center bg-blue-500">Information</li>
                <li class="flex-1 text-center">Password Change</li>
                <li class="flex-1 text-center">Delete Account</li>
                <li class="flex-1 text-center">Delete Account</li>
            </ul>

            <ul class="flex flex-row gap-2 w-full bg-slate-800 justify-between px-4 text-white">
                <li class="flex-1 text-center bg-blue-500 ">Information</li>
                <li class="flex-1 text-center bg-blue-500">Password Change</li>
                <li class="flex-1 text-center bg-blue-500">Delete Account</li>
            </ul>

            <ul class="flex flex-row gap-2 w-full bg-slate-800 justify-between px-4 text-white">
                <li class="flex-1 text-center ">
                    <div class="bg-blue-500 w-full h-full">Information</div>
                </li>
                <li class="flex-1 text-center bg-green-500">Password Change</li>
                <li class="flex-1 text-center bg-red-500">Delete Account</li>
            </ul>

        </div>
        <div class="bg-slate-300 h-8 w-full">ok</div>

    </div>

    {{-- <div class="max-w-7xl mx-auto  space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div> --}}
</div>
