<sidebar class="w-1/5 h-[calc(100%-65px)] border-r border-cyan-400 pt-4 ">

    <ul class="space-y-2 text-gray-600">

        <x-helpers.parts.nav-item icon="dashboard" label="Dashboard" link="dashboard" />
        <x-helpers.parts.nav-item icon="terminal" label="Debit Transaction" link="debit-transaction" />
        <x-helpers.parts.nav-item icon="add_card" label="Credit Transaction" link="credit-transaction" />

        <x-helpers.parts.nav-group icon="lab_profile" label="Report" link="report">
            <x-helpers.parts.nav-item label="Debit Txn Report" link="report/debit" :subMenu=true />
            <x-helpers.parts.nav-item label="Credit Txn Report" link="report/credit" :subMenu=true />
        </x-helpers.parts.nav-group>

        <x-helpers.parts.nav-group icon="settings" label="Settings" link="settings">
            <x-helpers.parts.nav-item label="Payment Method" link="settings/payment-method" :subMenu=true />
            <x-helpers.parts.nav-item label="Asset Types" link="settings/asset-types" :subMenu=true />
            <x-helpers.parts.nav-item label="Business Location" link="settings/business-location" :subMenu=true />
            <x-helpers.parts.nav-item label="Stores" link="settings/store" :subMenu=true />
        </x-helpers.parts.nav-group>

    </ul>

</sidebar>
