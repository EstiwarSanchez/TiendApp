<div x-data="noticesHandler()" class="fixed inset-0 flex flex-col-reverse items-end justify-end h-screen w-screen z-50"
    @notice.window="add($event.detail)" style="pointer-events:none">
    <template x-for="notice of notices" :key="notice.id">
        <div x-show="visible.includes(notice)" x-transition:enter="transition ease-in duration-200"
            x-transition:enter-start="transform opacity-0 translate-y-2" x-transition:enter-end="transform opacity-100"
            x-transition:leave="transition ease-out duration-500"
            x-transition:leave-start="transform translate-x-0 opacity-100"
            x-transition:leave-end="transform translate-x-full opacity-0" @click="remove(notice.id)"
            class="rounded mt-4 mr-6 max-w-sm p-4 flex-wrap w-auto flex text-white shadow-lg  text-lg cursor-pointer"
            :class="{
				'bg-psi-green-600': notice.type === 'success',
				'bg-psi-blue-600': notice.type === 'info',
				'bg-psi-orange-600': notice.type === 'warning',
				'bg-red-500': notice.type === 'error',
			 }" style="pointer-events:all">
             <div x-text="typeof notice.title != 'undefined' ? notice.title : ''" x-show="typeof notice.title != 'undefined'" class="font-bold w-full mb-1"></div>
             <div x-html="notice.text" class="font-semibold text-sm"></div>
        </div>
    </template>
</div>
