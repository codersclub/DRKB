---
Title: Пример шифрования данных
Date: 01.01.2007
---


Пример шифрования данных
========================

::: {.date}
01.01.2007
:::

    procedure DoEncode(var Source:String; const Key:string);

    asm
    Push ESI
    Push EDI
    Push EBX
    Or EAX,EAX
    Jz @Done
    Push EAX
    Push EDX
    Call UniqueString
    Pop EDX
    Pop EAX
    Mov EDI,[EAX]
    Or EDI,EDI
    Jz @Done
    Mov ECX,[EDI-4]
    Jecxz @Done
    Mov ESI,EDX
    Or ESI,ESI
    Jz @Done
    Mov EDX,[ESI-4]
    Dec EDX
    Js @Done
    Mov EBX,EDX
    Mov AH,DL
    Cld
    @L1:
    Test AH,8
    Jnz @L3
    Xor AH,1
    @L3:
    Not AH
    Ror AH,1
    Mov AL,[ESI+EBX]
    Xor AL,AH
    Xor AL,[EDI]
    Stosb
    Dec EBX
    Jns @L2
    Mov EBX,EDX
    @L2:
    Dec ECX
    Jnz @L1
    @Done:
    Pop EBX
    Pop EDI
    Pop ESI
    end;

Автор:Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Комментарий от Chingachguk\'a:

Мне кажется, у этого алгоритма есть два недостатка:

1) Код, сильно зависимый от компилятора. Далеко не всегда

регистр EAX будет указывать на ячейку с адресом Source,

а регистр EDX - на пароль(Key). Но это мелочь.

2) Единственный байт гаммы(или ксорирующей последовательности),

который меняется при шифровании - это длина пароля. Остальные

символы пароля НИКАК НЕ ПЕРЕМЕШИВАЮТСЯ в ходе шифрования. Алгоритм

шифрования примерно такой:

    Len:=Lengh(Key);
    Index:=Lengh(Key)-1;
    i:=1;
    repeat
    Len:=func1(Len);
    Source[i]:=(Key[Index] xor Len) xor Source[i];
    dec(Index);
    if Index:=0 then Index:=Lengh(Key)-1;
    until i<Lenght(Source);

Нетрудно видеть, что основной для тупого подбора является

длина пароля. Пусть она равна 10. Очевидно, что 1-ый,11,21..

символы будут зашифрованы ОДИНАКОВЫМ значением Key[Index],

но разными значениями Len. Казалось бы, Len для 1,11,21...

будет разным, но это ерунда - ведь Len вычисляется однозначно

на ЛЮБОМ шаге через реккурентный закон func1 !

И это - фатальный недостаток.

------------------------------------------------------------------------

Информацию по шифрованию можно найти на

<https://www.cryptography.ru/>

Автор ответа: Shaman

Взято с Vingrad.ru <https://forum.vingrad.ru>
