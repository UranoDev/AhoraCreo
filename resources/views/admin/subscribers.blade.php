
<x-app-layout>
    <x-slot name="header">
        <h2 class="serif font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Gestion de suscriptores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
                <div class="bg-white rounded-sm border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                    <p class="text-sm text-gray-500">{{ __('Total') }}</p>
                </div>
                <div class="bg-white rounded-sm border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $stats['verified'] }}</p>
                    <p class="text-sm text-gray-500">{{ __('Verified') }}</p>
                </div>
                <div class="bg-white rounded-sm border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['pdf_sent'] }}</p>
                    <p class="text-sm text-gray-500">{{ __('PDF Sent') }}</p>
                </div>
                <div class="bg-white rounded-sm border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['downloaded'] }}</p>
                    <p class="text-sm text-gray-500">{{ __('Downloaded') }}</p>
                </div>
                <div class="bg-white rounded-sm border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                    <p class="text-sm text-gray-500">{{ __('Pending') }}</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-sm">
                <div class="p-6">
                    <table class="w-full text-sm text-left">
                        <thead>
                        <tr class="border-b border-gray-200">
                            <th class="py-3 px-4 font-semibold text-gray-600">#</th>
                            <th class="py-3 px-4 font-semibold text-gray-600">{{ __('Email') }}</th>
                            <th class="py-3 px-4 font-semibold text-gray-600">{{ __('Status') }}</th>
                            <th class="py-3 px-4 font-semibold text-gray-600">{{ __('Verified At') }}</th>
                            <th class="py-3 px-4 font-semibold text-gray-600">{{ __('PDF Sent') }}</th>
                            <th class="py-3 px-4 font-semibold text-gray-600">{{ __('Downloaded') }}</th>
                            <th class="py-3 px-4 font-semibold text-gray-600">{{ __('Subscribed At') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-3 px-4 text-gray-500">
                                    {{ ($subscribers->currentPage() - 1) * $subscribers->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-3 px-4 font-medium text-gray-800">
                                    {{ $subscriber->email }}
                                </td>
                                <td class="py-3 px-4">
                                    @php $status = $subscriber->getStatusLabel(); @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium
                                            @if($status === 'downloaded') bg-green-100 text-green-800
                                            @elseif($status === 'pdf_sent') bg-blue-100 text-blue-800
                                            @elseif($status === 'verified') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                            @if($status === 'downloaded') {{ __('Downloaded') }}
                                        @elseif($status === 'pdf_sent') {{ __('PDF Sent') }}
                                        @elseif($status === 'verified') {{ __('Verified') }}
                                        @else {{ __('Pending') }}
                                        @endif
                                        </span>
                                </td>
                                <td class="py-3 px-4 text-gray-500">
                                    {{ $subscriber->email_verified_at?->format('M d, Y H:i') ?? '—' }}
                                </td>
                                <td class="py-3 px-4 text-gray-500">
                                    {{ $subscriber->pdf_sent_at?->format('M d, Y H:i') ?? '—' }}
                                </td>
                                <td class="py-3 px-4 text-gray-500">
                                    {{ $subscriber->pdf_downloaded_at?->format('M d, Y H:i') ?? '—' }}
                                </td>
                                <td class="py-3 px-4 text-gray-500">
                                    {{ $subscriber->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400">
                                    {{ __('No subscribers yet.') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $subscribers->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
