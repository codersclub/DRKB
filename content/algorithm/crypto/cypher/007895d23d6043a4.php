<h1>Пример шифрования данных</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>

<div class="author">Автор:Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<p>Комментарий от Chingachguk'a:</p>
<p>Мне кажется, у этого алгоритма есть два недостатка:</p>
<p>1) Код, сильно зависимый от компилятора. Далеко не всегда</p>
<p>регистр EAX будет указывать на ячейку с адресом Source,</p>
<p>а регистр EDX - на пароль(Key). Но это мелочь.</p>
<p>2) Единственный байт гаммы(или ксорирующей последовательности),</p>
<p>который меняется при шифровании - это длина пароля. Остальные</p>
<p>символы пароля НИКАК НЕ ПЕРЕМЕШИВАЮТСЯ в ходе шифрования. Алгоритм</p>
<p>шифрования примерно такой:</p>
<pre>
Len:=Lengh(Key);
Index:=Lengh(Key)-1;
i:=1;
repeat
Len:=func1(Len);
Source[i]:=(Key[Index] xor Len) xor Source[i];
dec(Index);
if Index:=0 then Index:=Lengh(Key)-1;
until i&lt;Lenght(Source);
</pre>

<p>Нетрудно видеть, что основной для тупого подбора является </p>
<p>длина пароля. Пусть она равна 10. Очевидно, что 1-ый,11,21..</p>
<p>символы будут зашифрованы ОДИНАКОВЫМ значением Key[Index],</p>
<p>но разными значениями Len. Казалось бы, Len для 1,11,21...</p>
<p>будет разным, но это ерунда - ведь Len вычисляется однозначно</p>
<p>на ЛЮБОМ шаге через реккурентный закон func1 !</p>
<p>И это - фатальный недостаток.</p>
<hr /><p>Информацию по шифрованию можно найти на </p>
<p><a href="https://www.cryptography.ru/" target="_blank">https://www.cryptography.ru/</a></p>
<div class="author">Автор: Shaman</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
