<x-app-layout>
      @if(auth()->user()->id == 1)

<div>
    {{-- <form action="{{route('stripe.charge')}}" method="POST">
    @csrf
     <script
         src="https://checkout.stripe.com/checkout.js" class="stripe-button"
         data-key="{{ env('STRIPE_KEY') }}"
         data-amount="100"
         data-name="お支払い画面"
         data-label="payment"
         data-description="現在はデモ画面です"
         data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
         data-locale="auto"
         data-currency="JPY">
     </script>
    </form> --}}
    <form action="{{route('stripe.charge')}}" method="POST">
    @csrf
    <button type="submit">Checkout</button>
    </form>
</div>
@else
<div>
    <p style="text-align: center; margin-top:30px">デモでは寄付できません。</p>
</div>
@endif
</x-app-layout>