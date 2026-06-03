<div class="py-2">
    <form wire:submit.prevent="save">
        @csrf
        <div class="space-y-6">
            <!-- Role Name -->
            <div class="max-w-md">
                <x-input-label for="name" :value="__('Role Name')" required />
                <x-text-input id="name" type="text" placeholder="e.g. Inventory Manager" class="mt-1 block w-full"
                    wire:model="name" required autocomplete="name"
                    value="{{ old('name', $role->name ?? '') }}" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Permissions Mapping -->
            <div class="w-full">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Assign Permissions</h3>
                </div>

                @php
                    // Group permissions by resource/module
                    $groupedPermissions = [];
                    foreach ($permissions as $permission) {
                        $parts = explode(' ', $permission->name);
                        $groupName = count($parts) > 1 ? ucfirst($parts[1]) : 'Other';
                        $groupedPermissions[$groupName][] = $permission;
                    }
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($groupedPermissions as $group => $perms)
                        @php
                            $groupPermNames = array_map(fn($p) => $p->name, $perms);
                            $groupSelected = count(array_intersect($groupPermNames, $selectedPermissions)) === count($groupPermNames);
                        @endphp
                        <div wire:key="group-{{ strtolower($group) }}" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-sm p-4">
                            <div class="flex items-center gap-2 mb-3 pb-1 border-b border-slate-200 dark:border-slate-800">
                                <input type="checkbox" onclick="toggleGroupCheckboxes(this, {{ json_encode($groupPermNames) }})" {{ $groupSelected ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-slate-300 dark:border-slate-700 dark:bg-slate-850 rounded focus:ring-blue-500 cursor-pointer" />
                                <h4 class="font-bold text-xs text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    {{ $group }} Management
                                </h4>
                            </div>
                            <div class="space-y-2">
                                @foreach ($perms as $perm)
                                    <label wire:key="perm-{{ $perm->id }}" class="flex items-center gap-2.5 text-xs text-slate-600 dark:text-slate-400 cursor-pointer select-none">
                                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->name }}"
                                            class="w-4 h-4 text-blue-600 border-slate-300 dark:border-slate-700 dark:bg-slate-850 rounded focus:ring-blue-500" />
                                        <span>{{ ucwords($perm->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('selectedPermissions')" class="mt-2" />
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-200">
            <x-button variant="primary" type="submit" size="sm">
                <svg height="14" width="14" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.008 2H2.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275v11.436c0 .181.002.245.007.275c.03.005.094.007.275.007h11.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V4.62c0-.13-.001-.18-.004-.204a2.654 2.654 0 0 0-.141-.147L11.73 2.145a2.654 2.654 0 0 0-.147-.141A2.654 2.654 0 0 0 11.38 2h-.388c.005.08.008.172.008.282v2.436c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H6.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378C5.046 5.325 5 5.164 5 4.718V2.282c0-.11.003-.202.008-.282M2.282 1h9.098c.259 0 .348.01.447.032a.87.87 0 0 1 .273.113c.086.054.156.11.338.293l2.124 2.124c.182.182.239.252.293.338a.87.87 0 0 1 .113.273c.023.1.032.188.032.447v9.098c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H2.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378c-.088-.163-.134-.324-.134-.77V2.282c0-.446.046-.607.134-.77a.909.909 0 0 1 .378-.378c.163-.088.324-.134.77-.134M6 2.282v2.436c0 .181.002.245.007.275c.03.005.094.007.275.007h3.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V2.282c0-.181-.002-.245-.007-.275A2.248 2.248 0 0 0 9.718 2H6.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275M8 12a2 2 0 1 1 0-4a2 2 0 0 1 0 4m0-1a1 1 0 1 0 0-2a1 1 0 0 0 0 2"
                        fill="currentColor" />
                </svg>&nbsp;
                {{ __('Submit') }}
            </x-button>
        </div>
    </form>
</div>

<script>
function toggleGroupCheckboxes(parentCheckbox, permNames) {
    const isChecked = parentCheckbox.checked;
    permNames.forEach(name => {
        const cb = document.querySelector(`input[wire\\:model="selectedPermissions"][value="${name}"]`);
        if (cb) {
            if (cb.checked !== isChecked) {
                cb.checked = isChecked;
                cb.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    });
}
</script>
