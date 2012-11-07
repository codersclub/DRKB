<h1>Указатель на вариантный тип</h1>
<div class="date">01.01.2007</div>

I just ran across this in some of my old code and thought I''d share it with you:</p>
<p>Consider the following (simplified code):</p>
<pre>
 function CreateVariantPtr(_Value: variant): pVariant;
 begin
 GetMem(Result, SizeOf(Variant));
 Result^ := _Value;
 end;
</pre>
<p>Seems pretty simple, doesn''t it? Anybody who can spot the bug? I got spurious access violations in the line Result^ := _Value; Ok, the reason: Memory allocated with GetMem is not initialised, so the "Variant" pointed to by Result contains some random data, for example something that might represent a variant type which requires some finalisation when the variant is changed, lets say a variant array of some sort. But this finalisation won''t work because the content is just some random garbage, and sometimes I was lucky (I mean that!) and got an access violation that allowed me to spot the error. The fix:</p>
<pre>
 function CreateVariantPtr(_Value: variant): pVariant;
 begin
 GetMem(Result, SizeOf(Variant));
 Initialize(Result^);
 Result^ := _Value;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
</p>

