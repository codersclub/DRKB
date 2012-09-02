<h1>Шифрование и дешифрование текстов по принципу S-Coder со скрытым ключом</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Шифрование и дешифрование текстов по принципу S-Coder со скрытым ключом
 
После прменения выполнения функции Encrypt с входным исходным 
текстом, результат будет иметь символы в диапазоне от 
0 - 255 в ASCII таблице, следовательно если вам надо сохранить 
где либо шифровку, то лучше преобразовать в числовой вид - 
16разрядный hex из ASCII таблицы (функция Write)
 
Зависимости: Windows, SysUtils
Автор:       Yuri Btr, btr1978@rambler.ru, ICQ:125988632, Керчь
Copyright:   EFD Systems http://www.mindspring.com/~efd
Дата:        23 мая 2002 г.
********************************************** }
 
procedure EnCipher(var Source:AnsiString);
 
  {Low order, 7-bit ASCII (char. 32-127) encryption designed for database use.
   Control and high order (8 bit) characters are passed through unchanged.
 
   Uses a hybrid method...random table substitution with bit-mangled output.
   No passwords to worry with (the built-in table is the password). Not industrial
   strength but enough to deter the casual hacker or snoop. Even repeating char.
   sequences have little discernable pattern once encrypted.
 
   NOTE: When displaying encrypted strings, remember that some characters
         within the output range are interpreted by VCL components; for
         example, '&amp;'.}
 
  asm
    Push ESI //Save the good stuff
    Push EDI
 
    Or EAX,EAX
    Jz @Done
    Push EAX
    Call UniqueString
    Pop EAX
    Mov ESI,[EAX] //String address into ESI
    Or ESI,ESI
    Jz @Done
    Mov ECX,[ESI-4] //String Length into ECX
    Jecxz @Done //Abort on null string
    Mov EDX,ECX //initialize EDX with length
    Lea EDI,@ECTbl //Table address into EDI
    Cld //make sure we go forward
@L1:
    Xor EAX,EAX
    Lodsb //Load a byte from string
    Sub AX,32 //Adjust to zero base
    Js @Next //Ignore if control char.
    Cmp AX,95
    Jg @Next //Ignore if high order char.
    Mov AL,[EDI+EAX] //get the table value
    Test CX,3 //screw it up some
    Jz @L2
    Rol EDX,3
@L2:
    And DL,31
    Xor AL,DL
    Add EDX,ECX
    Add EDX,EAX
    Add AL,32 //adjust to output range
    Mov [ESI-1],AL //write it back into string
@Next:
    Dec ECX
    Jnz @L1
// Loop @L1 //do it again if necessary
 
@Done:
    Pop EDI
    Pop ESI
 
    Jmp @Exit
// Ret //this does not work with Delphi 3 - EFD 971022
 
@ECTbl: //The encipher table
    DB 75,85,86,92,93,95,74,76,84,87,91,94
    DB 63,73,77,83,88,90,62,64,72,78,82,89
    DB 51,61,65,71,79,81,50,52,60,66,70,80
    DB 39,49,53,59,67,69,38,40,48,54,58,68
    DB 27,37,41,47,55,57,26,28,36,42,46,56
    DB 15,25,29,35,43,45,14,16,24,30,34,44
    DB 06,13,17,23,31,33,05,07,12,18,22,32
    DB 01,04,08,11,19,21,00,02,03,09,10,20
@Exit:
 
  end;
 
 
procedure DeCipher(var Source:AnsiString);
 
  {Decrypts a string previously encrypted with EnCipher.}
 
  asm
    Push ESI //Save the good stuff
    Push EDI
    Push EBX
 
    Or EAX,EAX
    Jz @Done
    Push EAX
    Call UniqueString
    Pop EAX
    Mov ESI,[EAX] //String address into ESI
    Or ESI,ESI
    Jz @Done
    Mov ECX,[ESI-4] //String Length into ECX
    Jecxz @Done //Abort on null string
    Mov EDX,ECX //Initialize EDX with length
    Lea EDI,@DCTbl //Table address into EDI
    Cld //make sure we go forward
@L1:
    Xor EAX,EAX
    Lodsb //Load a byte from string
    Sub AX,32 //Adjust to zero base
    Js @Next //Ignore if control char.
    Cmp AX,95
    Jg @Next //Ignore if high order char.
    Mov EBX,EAX //save to accumulate below
    Test CX,3 //unscrew it
    Jz @L2
    Rol EDX,3
@L2:
    And DL,31
    Xor AL,DL
    Add EDX,ECX
    Add EDX,EBX
    Mov AL,[EDI+EAX] //get the table value
    Add AL,32 //adjust to output range
    Mov [ESI-1],AL //store it back in string
@Next:
    Dec ECX
    Jnz @L1
// Loop @L1 //do it again if necessary
 
@Done:
    Pop EBX
    Pop EDI
    Pop ESI
 
    Jmp @Exit
// Ret Does not work with Delphi3 - EFD 971022
 
@DCTbl: //The decryption table
    DB 90,84,91,92,85,78,72,79,86,93,94,87
    DB 80,73,66,60,67,74,81,88,95,89,82,75
    DB 68,61,54,48,55,62,69,76,83,77,70,63
    DB 56,49,42,36,43,50,57,64,71,65,58,51
    DB 44,37,30,24,31,38,45,52,59,53,46,39
    DB 32,25,18,12,19,26,33,40,47,41,34,27
    DB 20,13,06,00,07,14,21,28,35,29,22,15
    DB 08,01,02,09,16,23,17,10,03,04,11,05
@Exit:
  end;
 
 
procedure Crypt(var Source:Ansistring;const Key:AnsiString);
 
  {Encrypt AND decrypt strings using an enhanced XOR technique similar to
   S-Coder (DDJ, Jan. 1990). To decrypt, simply re-apply the procedure
   using the same password key. This algorithm is reasonably secure on
   it's own; however,there are steps you can take to make it even more
   secure.
 
         1) Use a long key that is not easily guessed.
         2) Double or triple encrypt the string using different keys.
            To decrypt, re-apply the passwords in reverse order.
         3) Use EnCipher before using Crypt. To decrypt, re-apply Crypt
            first then use DeCipher.
         4) Some unique combination of the above
 
   NOTE: The resultant string may contain any character, 0..255.}
 
 
  asm
    Push ESI //Save the good stuff
    Push EDI
    Push EBX
 
    Or EAX,EAX
    Jz @Done
    Push EAX
    Push EDX
    Call UniqueString
    Pop EDX
    Pop EAX
    Mov EDI,[EAX] //String address into EDI
    Or EDI,EDI
    Jz @Done
    Mov ECX,[EDI-4] //String Length into ECX
    Jecxz @Done //Abort on null string
    Mov ESI,EDX //Key address into ESI
    Or ESI,ESI
    Jz @Done
    Mov EDX,[ESI-4] //Key Length into EDX
    Dec EDX //make zero based
    Js @Done //abort if zero key length
    Mov EBX,EDX //use EBX for rotation offset
    Mov AH,DL //seed with key length
    Cld //make sure we go forward
@L1:
    Test AH,8 //build stream char.
    Jnz @L3
    Xor AH,1
@L3:
    Not AH
    Ror AH,1
    Mov AL,[ESI+EBX] //Get next char. from Key
    Xor AL,AH //XOR key with stream to make pseudo-key
    Xor AL,[EDI] //XOR pseudo-key with Source
    Stosb //store it back
    Dec EBX //less than zero ?
    Jns @L2 //no, then skip
    Mov EBX,EDX //re-initialize Key offset
@L2:
    Dec ECX
    Jnz @L1
@Done:
    Pop EBX //restore the world
    Pop EDI
    Pop ESI
  end;
 
 function Encrypt(text:Ansistring):Ansistring;
//Это прсто интерфейс функций EnCipher и Crypt для шифрования строки текста
begin
 {шифруем текст}
 EnCipher(Text);
 {зашифровываем ключом в Edit1}
 Crypt(Text,Form1.Edit1.Text);
 Result:=Text;
end;
 
 
function Decrypt(text:Ansistring):Ansistring;
//Это прсто интерфейс функций EnCipher и Crypt для дешифрования строки текста begin
begin
 {расшифровываем ключом в Edit1}
 Crypt(Text,Form1.Edit1.Text);
 {расшифровываем результат}
 DeCipher(Text);
 Result:=Text;
end;
 
 
function Write(text:Ansistring):Ansistring;
var
 i:integer;
begin
 Result:='';
 For i:=1 to Length(text)
  do
   {получаем hex код из текста}
   Result:=Result+InttoHex(ord(text[i]),2);
end;
 
function Read(text:Ansistring):Ansistring;
var
 i:integer;
begin
 Result:='';
 For I:=1 to Length(text)
  do
   if odd(i)
    then
     {получаем текст из hex кода} 
     Result:=Result+Chr(StrtoInt('$'+text[i]+text[i+1]));
end; 
</pre>

<p> Пример использования:</p>
<p>функции вставляем после Implementation</p>
<p>и после {$R *.dfm}</p>
<p>В программе пишем просто:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
 {Задайте здесь ваш секретный ключ}
 Edit1.text:='My special hidden key'; 
 {Шифруем и преобразовываем тест в Memo1 и заносим результат в Memo2}
 Memo2.text:=Write(Encrypt(Memo1.text));
 {Дешифруем и преобразовываем тест в Memo2 и заносим результат в Memo3}
 Memo3.text:=Decrypt(Read(Memo2.text));));
end; 
</pre>

