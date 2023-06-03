@component('mail::message')
# عزيزي {{ $user->first_name }} {{ $user->last_name }},

الوزن الحالي للمركبة ({{ $trip->plate_number }}) تخطى الحد الأقصى للوزن. الوزن الحالي للمركبة هو {{ $trip->enterance_weight }} و الحد الأقصى للوزن {{ $trip->max_weight }}.

اطيب التحيات,,,<br>
فريق عمل مردم جدة الذكي<br>
@endcomponent
