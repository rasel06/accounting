<sidebar class="w-1/5 h-[calc(100vh-64px)] border-r-2">

    <ul class="space-y-2 text-gray-600">
        <li>
            <a href="#"
                class="flex items-center p-2 text-base font-normal  rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                <span class="material-symbols-outlined">
                    dashboard
                </span>
                <span class="ml-3">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="#"
                class="flex items-center p-2 text-base font-normal rounded-lg  hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">
                <span class="material-symbols-outlined">
                    terminal
                </span>
                <span class="ml-3">Debit</span>
            </a>
        </li>
        <li>
            <a href="#"
                class="flex items-center p-2 text-base font-normal  rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                <span class="material-symbols-outlined">
                    add_card
                </span>
                <span class="ml-3">Credit</span>
            </a>
        </li>
        <li>
            <button type="button"
                class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                aria-controls="dropdown-report" data-collapse-toggle="dropdown-report">
                <span class="material-symbols-outlined">
                    lab_profile
                </span>
                <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Report</span>
                <span class="material-symbols-outlined">
                    keyboard_arrow_down
                </span>

            </button>
            <ul id="dropdown-report" class="hidden py-2 space-y-1">
                <li>
                    <a href="#"
                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">Debit
                        Report</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">Credit
                        Report</a>
                </li>

            </ul>
        </li>
        <li>
            <button type="button"
                class="flex items-center w-full p-2 text-base font-normal text-gray-600 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                aria-controls="dropdown-settings" data-collapse-toggle="dropdown-settings">
                <span class="material-symbols-outlined">
                    settings
                </span>
                <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Settings</span>
                <span class="material-symbols-outlined">
                    keyboard_arrow_down
                </span>
            </button>
            <ul id="dropdown-settings"
                class="hidden py-2 space-y-1 {{ request()->routeIs('settings.*') == true ? '' : 'hidden' }}">
                <li>
                    <a href="/settings/payment-method"
                        class="flex items-center w-full p-2 text-base font-normal text-gray-600 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">
                        Payment Method</a>
                </li>
                <li>
                    <a href="/settings/asset-types"
                        class="flex items-center w-full p-2 text-base font-normal text-gray-600 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">
                        Asset Types</a>
                </li>
                <li>
                    <a href="/settings/location"
                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">Business
                        Location</a>
                </li>

                <li>
                    <a href="/settings/store"
                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">Stores</a>
                </li>

            </ul>
        </li>
    </ul>


</sidebar>
