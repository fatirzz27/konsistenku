@php
	$brandName = config('app.name', 'KonsistenKu');

	if (strtolower(trim($brandName)) === 'laravel') {
		$brandName = 'KonsistenKu';
	}

	$currentStreak = $habit->streak?->current_streak ?? 0;
@endphp

<x-mail::message>
# Pengingat Aktivitas Harian

Halo {{ $habit->user->name }},

Ini adalah pengingat untuk menyelesaikan aktivitas Anda hari ini.

<x-mail::panel>
<strong>{{ $habit->name }}</strong><br>
Streak saat ini: <strong>{{ $currentStreak }} hari</strong>
@if($habit->reminder_time)
<br>Jam pengingat: <strong>{{ \Illuminate\Support\Carbon::parse($habit->reminder_time)->format('H:i') }}</strong>
@endif
</x-mail::panel>

<x-mail::button :url="route('reminders.open', $habit)">
Buka Halaman Habit
</x-mail::button>

Jika Anda sudah melakukan check-in hari ini, abaikan email ini.

Salam hormat,<br>
Tim {{ $brandName }}
</x-mail::message>