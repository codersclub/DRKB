<h1>Взлом Windows-приложений</h1>
<div class="date">01.01.2007</div>


<p>Введение</p>

<p>Для начала я научу вас пользоваться W32Dasm. Я не хочу вам давать детальную помощь, как делать краки, но я могу научить вас самим добывать себе умения и навыки взлома. Когда вы используете W32Dasm, знайте, что он не даст вам серийные номера или коды, он лишь покажет путь, где находится место, где можно эти номера вводить. То, что я делаю каждый день при взломе программ, будет описано в этом справочнике, шаг за шагом.</p>

<p>Инструменты</p>

<p>Из инструментов взлома вам нужно следующее:</p>

<p>W32Dasm 8.5 или боолее позднюю версию,</p>
<p>Hacker's View 5.24,</p>
<p>Norton Commander (я позднее объясню, почему я его использую).</p>
<p>Turbo Pascal 7.0</p>
<p>TASM и TLINK 3.0</p>
<p>Как кракнуть Quick View Plus 4.0</p>

<p>Запустите ORDER32.EXE</p>
<p>Кликните на $49 Single User License (вы можете кликнуть и на $59), затем ACCEPT, потом UNLOCK BY PHONE.</p>
<p>Введите любой код для получения сообщения об ошибке (вы должны записать это сообщение), потом выйдите из программы, кликнув на CANCEL.</p>
<p>Запустите Norton Comander, перейдите в директорию QVP.</p>
<p>Скопируйте ORDER32.EXE в ORDER32.EXX (для сохранности), а затем скопируйте ORDER32.EXE в 1.EXE (для использования в W32Dasm).</p>
<p>Запустите W32Dasm и раздессимблируйте 1.EXE.</p>
<p>После этого, кликните на STRING DATA REFERENCE, найдите там сообщение "You have entered an incorrect code.Please check your entry" (вы должны помнить,что это было сообщение об ошибке) и дважды щелкните мышью по нему.</p>
<p>Закройте SDR окно. Вы должны увидеть сообщение:</p>

<p>* Possible reference to String Resource ID=00041: "You have entered...</p>
<p>:004049F8 6A29 push 00000029</p>
<p>:004049FA FF353CCE4000 push dword ptr [0040CE3C]</p>


<p>ОК, теперь вы должны найти последнее сравнение типа CMP,JNE, JE,TEST и т.д. перед сообщением об ошибке. Нажимайте стрелку "вверх", пока не найдете:</p>

<p>:004049CD 755A jne 00404A29</p>
<p>* Possible reference to String Resource ID=00032: "You must select...</p>
<p>:004049CF 6A20 push 00000020</p>
<p>...</p>
<p>...</p>
<p>* Possible reference to String Resource ID=00040: "Unlock Error"</p>


<p>Теперь вы знаете, куда идет скачок при введении неправильного кода. Теперь можно посмотреть, что произойдет, если "jne" на "je". Убедитесь, что зеленая полоска находится на надписи:</p>

<p>004049CD 755A jne 00404A29, вы должны увидеть Offset address внизу на статусной строке типа @Offset 00003DCDh Это место, где вы можете внести изменения в ORDER32.EXE.</p>


<p>Перейдите обратно в Norton Commander, запустите HIEW ORDER32.EXE, нажмите F4 для выбора режима декодирования (Decode Mode), нажмите F5 и введите 3DCD. Вы должны увидеть следующее :</p>

<p>00003DCD: 755A jne 000003E29</p>
<p>00003DCF: 6A20 push 020</p>
<p>00003DD1: FF15 call w,[di]</p>


<p>Это то место, где вы можете изменить байты, нажмите F3, введите 74, нажмите F9 для обновления ORDER32.EXE. Выйдите из HIEW.</p>
<p>Запустите ORDER32.EXE, введите любой код. Ура ! Мы сломали QVP 4.0 ! Но ! Что будет, если ввести настоящий серийный номер ? Появляется сообщение об ошибке ! Что это ?</p>
<p>Снова запустиите HIEW ORDER32.EXE, нажмите F4, выберите Decode, нажмите F5 и введите 3DCD. Нажмите F3, введите EB, нажмите F9. Вы прямо "прыгнете" на Unlocked диалог.</p>
<p>Как кракнуть Hex WorkShop 2.51</p>

<p>Запустите HWORKS32.EXE</p>
<p>Кликните на HELP, About HEX Wo..</p>
<p>Введите любой код, чтобы получить сообщение об ошибке (вы должны записать это сообщение) и выйдите из программы.</p>
<p>Запустите Norton Commander, перейдите в директорию HWS.</p>
<p>Скопируйте файл HWORKS32.EXE в HWORKS32.EXX (для сохранности) и скопируйте файл HWORKS32.EXE в 1.EXE (для использования в W32Dasm).</p>
<p>Запустите W32Dasm и "разберите" 1.EXE.</p>
<p>После этого, нажмите мышью на FIND TEXT, введите "You have entered an" (вы должны помнить, что это сообщение об ошибочно введенном серийном номере) и найдите соответствующую строку (вы не сможете сделать это в SDR-окне !)</p>
<p>Вы должны увидеть следующую строку:</p>

<p>Name: DialogID_0075, # of Controls=003, Caption: "Registration Unsucce..</p>
<p>001-ControlID:FFFF, Control Class:""Control Text:"You have entered an..</p>
<p>002-ControlID:FFFF, Control Class:""Control Text:"Please confirm you..</p>


<p>Оk, теперь вы знаете, что ControlID будет использоваться, когда вы введете неверный код. Кликните FIND TEXT, введите "dialogid_0075" и вы найдете:</p>

<p>* Possible reference to DialogID_0075</p>
<p>:0041E233 6A75 push 00000075</p>
<p>:0041E235 8D8D10FFFFFF lea ecx, dword ptr [ebp+FF10]</p>


<p>Теперь вы должны поискать последнюю ссылку, типа CMP, JNE, JE и пр. перед диалогом об ошибке. Нажимайте клавишу "вверх", пока не найдете :</p>

<p>:0041E145 837DEC00 cmp dword ptr [ebp-14], 00000000</p>
<p>:0041E149 0F8479000000 je 0041E1C8</p>
<p>:0041E14F 8B8DFCFEFFFF mov ecx, dword ptr [ebp+FEFC]</p>


<p>Теперь вам нужно посмотреть, что произойдет, если "je" заменить на "jne". Убедитесь, что зеленая полоска установлена на строке</p>

<p>:0041E149 0F8479000000 je 0041E1C8.</p>


<p>Вы должны на нижней статусной строке увидеть оффсетный адрес, типа:</p>

<p>@Offset0001D549h.</p>


<p>Это то место, где вы сможете кракнуть HWORKS32.EXE</p>
<p>Перейдите обратно в Norton Commander, запустите HIEW HWORKS32.EXE, нажмите F4 для выбора режима декодирования (Decode Mode), нажмите F5 и введите ID549. Вы должны увидеть следующее :</p>

<p>0001D549: 0F847900 je 00001D5C6 ---------- (1)</p>
<p>0001D54D: 0000 add [bx][si],al</p>
<p>0001D54F: 8B8DFCFE mov cx,[di][0FEFC]</p>


<p>Это то место, где вы сможете изменить несколько байтов, нажмите F3, введите 0F85, нажмите F9 для обновления файла HWORKS32.EXE. Выйдите из HIEW.</p>
<p>Запустите HWORKS32.EXE и введите любой код, работает ? НЕТ !?!??!?! Хе-хе-хе... Не волнуйтесь ! Снова перейдите в Нортон. Скопируйте HWORKS32.EXX в HWORKS32.EXE (теперь вы видите, почему я делаю копию файла с расширением ЕХХ для сохранности). Теперь перейдите в W32Dasm, вы должны перейти туда, где только что были (на 0041У145).</p>
<p>Нажмите F3 для очередного поиска "DialogID_0075", вы должны найти:</p>

<p>* Possible reference to DialogID_0075</p>
<p>:00430ADD 6A75 push 00000075</p>
<p>:00430ADF 8D8D10FFFFFF lea ecx, dword ptr [ebp+FF10]</p>


<p>Ok, теперь вы теперь можете посмотреть на последние ссылки, типа CMP, JNE, JE и т.д. перед диалогом об ошибке. Нажимайте стрелку вверх, пока не найдете :</p>

<p>:004309EF 837DEC00 cmp dword ptr [ebp-14], 00000000</p>
<p>:004309F3 0F8479000000 je 00430A72</p>
<p>:004309F9 8B8DFCFEFFFF mov ecx, dword ptr [ebp+FEFC]</p>


<p>Теперь вы можете посмотреть, что произойдет, если "je" заменить на 'jne". (это должно сработать). Переместите полоску на:</p>

<p>004309F3 0F8479000000 je 00430A72.</p>


<p>На статусной строке внизу экрана вы должны следующее:</p>

<p>@Offset0002FDF3h (оффсетный адрес).</p>


<p>Это то место, где вы сможете кракнуть HWORKS32.EXE.</p>
<p>Перейдите в Norton Commander, запустите HIEW HWORKS32.EXE, нажмите F4 для выбора Decode Mode (ASM), нажмите F5 и введите 2FDF3. Вы должны увидеть:</p>

<p>0002FDF3: 0F847900 je 00001D5C6 ---------- (1)</p>
<p>0002FDF7: 0000 add [bx][si],al</p>
<p>0002FDF9: 8B8DFCFE mov cx,[di][0FEFC]</p>


<p>Это то место, где вы сможете изменить несколько байтов, нажмите F3, введите 0F85, нажмите F9 для обновления файла HWORKS32.EXE. Выйдите из HIEW.</p>
<p>Запустите снова HWORKS32.EXE и введите любой код. Работает ? Виола !!! Поздравляю !!! Вы крякнули HEX WorkShop 2.51 !</p>
<p>Как сделать собственный патч</p>

<p>Здесь напечатан исходный код на Паскале :</p>
<pre>
uses Crt;
 
const
  A: array[1..1] of record {&lt;-------- 1 byte to be patched}
    A: Longint;
    B: Byte;
 
  end =
  ((A: $3DCD; B: $EB));
    {&lt;--------------- offset "3DCD" and byte "EB" to be changed}
 
var
  Ch: Char;
  I: Byte;
  F: file;
  FN: file of byte;
  Size: longint;
 
begin
  Writeln('TKC Little Patch');
  writeln('Crack for QVP 4.0 by TKC/PC 97');
  Assign(F, 'ORDER32.EXE'); {&lt;-------------- filename to be patched}
{$I-}Reset(F, 1);
{$I+}
  if IOResult &lt;&gt; 0 then
  begin
    writeln('File not found!');
    halt(1);
  end;
  for I := 1 to 1 do {&lt;---------------------- 1 byte to be patched}
 
  begin
    Seek(F, A[I].A);
    Ch := Char(A[I].B);
    Blockwrite(F, Ch, 1);
  end;
  Writeln('File successfully patched!');
 
end.
</pre>




<p>Исходник на ассемблере (для изучающих ассемблер):</p>
<pre>DOSSEG
.MODEL SMALL
.STACK 500h
.DATA
.CODE
PatchL EQU 6
Buffer Db PatchL Dup(1)
handle dw ?
intro db "TKC's Little Patch",0dh,0ah,"Crack for QVP 4.0 by TKC/PC '97$"

FileName db "ORDER32.EXE",0 ;&lt;------- filename to be patched
notfound db 0dh,0ah,"File not found!$"
cracked db 0dh,0ah,"File successfully patched. Enjoy!$"
Cant db 0dh,0ah,"Can't write to file.$"
Done db "File has been made.$"
String db 0EBh,0 ;&lt;------------- byte "EB" to be patched

START:
mov ax,cs
mov ds,ax
mov dx,offset intro ;point to the time prompt
mov ah,9 ;DOS: print string
int 21h
jmp openfile

openfile:

mov ax,cs
mov ds,ax
mov ax,3d02h
mov dx,offset FileName
int 21h
mov handle,ax
cmp ax,02h
je filedontexist
jmp write

filedontexist:
mov ax,cs
mov ds,ax
mov dx,offset notfound
mov ah,9 ;DOS: print string
int 21h ;display the time prompt
jmp exit

Write:
mov bx,handle
mov cx,0000h
mov dx,3DCDh ;&lt;------------- offset "3DCD"
mov ax,4200h
int 21h

mov cx,patchl
mov dx,offset String
mov ah,40h
mov cx,01h
int 21h
mov ax,cs
mov ds,ax
mov dx,offset cracked
mov ah,9 ;DOS: print string
int 21h ;display the time prompt
jmp Exit

Exit:
mov ah,3eh
int 21h
mov ax,4c00h
int 21h
END START
</pre>




<p>Заключительные слова</p>

<p>Здесь несколько важных функций, используемых для крэкинга :</p>


<p>Hex: Asm: Means</p>
<p>75 &nbsp; &nbsp; &nbsp; &nbsp;or 0F85 jne jump if not equal</p>
<p>74 &nbsp; &nbsp; &nbsp; &nbsp;or 0F84 je jump if equal</p>
<p>EB &nbsp; &nbsp; &nbsp; &nbsp;jmp  &nbsp; &nbsp; &nbsp; &nbsp;jump directly to</p>
<p>90  &nbsp; &nbsp; &nbsp; &nbsp;nop  &nbsp; &nbsp; &nbsp; &nbsp;no operation</p>
<p>77  &nbsp; &nbsp; &nbsp; &nbsp;or 0F87 ja jump if above</p>
<p>0F86  &nbsp; &nbsp; &nbsp; &nbsp;jna  &nbsp; &nbsp; &nbsp; &nbsp;jump if not above</p>
<p>0F83  &nbsp; &nbsp; &nbsp; &nbsp;jae  &nbsp; &nbsp; &nbsp; &nbsp;jump if above or equal</p>
<p>0F82  &nbsp; &nbsp; &nbsp; &nbsp;jnae  &nbsp; &nbsp; &nbsp; &nbsp;jump if not above or equal</p>
<p>0F82  &nbsp; &nbsp; &nbsp; &nbsp;jb  &nbsp; &nbsp; &nbsp; &nbsp;jump if below</p>
<p>0F83  &nbsp; &nbsp; &nbsp; &nbsp;jnb  &nbsp; &nbsp; &nbsp; &nbsp;jump if not below</p>
<p>0F86  &nbsp; &nbsp; &nbsp; &nbsp;jbe  &nbsp; &nbsp; &nbsp; &nbsp;jump if below or equal</p>
<p>0F87  &nbsp; &nbsp; &nbsp; &nbsp;jnbe  &nbsp; &nbsp; &nbsp; &nbsp;jump if not below or equal</p>
<p>0F8F  &nbsp; &nbsp; &nbsp; &nbsp;jg  &nbsp; &nbsp; &nbsp; &nbsp;jump if greater</p>
<p>0F8E  &nbsp; &nbsp; &nbsp; &nbsp;jng  &nbsp; &nbsp; &nbsp; &nbsp;jump if not greater</p>
<p>0F8D  &nbsp; &nbsp; &nbsp; &nbsp;jge  &nbsp; &nbsp; &nbsp; &nbsp;jump if greater or equal</p>
<p>0F8C  &nbsp; &nbsp; &nbsp; &nbsp;jnge  &nbsp; &nbsp; &nbsp; &nbsp;jump if not greater or equal</p>
<p>0F8C  &nbsp; &nbsp; &nbsp; &nbsp;jl  &nbsp; &nbsp; &nbsp; &nbsp;jump if less</p>
<p>0F8D  &nbsp; &nbsp; &nbsp; &nbsp;jnl  &nbsp; &nbsp; &nbsp; &nbsp;jump if not less</p>
<p>0F8E  &nbsp; &nbsp; &nbsp; &nbsp;jle  &nbsp; &nbsp; &nbsp; &nbsp;jump if less or equal</p>
<p>0F8F  &nbsp; &nbsp; &nbsp; &nbsp;jnle  &nbsp; &nbsp; &nbsp; &nbsp;jump if not less or equal</p>


<p>Ваши небольшие знания по Ассемберу, вам, естественно, помогут, и они вам потребуются для использования Soft-ICE. Кроме того, вы сможете кракать эти куски с помощью W32Dasm как маньяк :-) Вы не сможете дизассемблировать программы на Visual Basic, для него вам понадобятся специальные декомпилеры, но с помощью SoftIce'a поломать их можно и без декомпилятора.</p>

<p>Удачи !</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

