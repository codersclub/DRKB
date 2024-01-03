---
Title: Указатель на вариантный тип
Date: 01.01.2007
---


Указатель на вариантный тип
===========================

::: {.date}
01.01.2007
:::

I just ran across this in some of my old code and thought I\'\'d share
it with you:

Consider the following (simplified code):

     function CreateVariantPtr(_Value: variant): pVariant;
     begin
     GetMem(Result, SizeOf(Variant));
     Result^ := _Value;
     end;

Seems pretty simple, doesn\'\'t it? Anybody who can spot the bug? I got
spurious access violations in the line Result^ := \_Value; Ok, the
reason: Memory allocated with GetMem is not initialised, so the
"Variant" pointed to by Result contains some random data, for example
something that might represent a variant type which requires some
finalisation when the variant is changed, lets say a variant array of
some sort. But this finalisation won\'\'t work because the content is
just some random garbage, and sometimes I was lucky (I mean that!) and
got an access violation that allowed me to spot the error. The fix:

     function CreateVariantPtr(_Value: variant): pVariant;
     begin
     GetMem(Result, SizeOf(Variant));
     Initialize(Result^);
     Result^ := _Value;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

 
