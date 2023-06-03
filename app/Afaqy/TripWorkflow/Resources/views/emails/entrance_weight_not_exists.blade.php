@component('mail::message')
# عزيزي {{ $user->first_name }} {{ $user->last_name }},

لم تقم المركبة ({{ $trip->plate_number }}) بالمرور على ميزان الدخول.

اطيب التحيات,,,<br>
فريق عمل مردم جدة الذكي<br>
@endcomponent
