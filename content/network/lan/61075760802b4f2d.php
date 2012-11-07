<h1>Создание Аккаунта в Windows, используя ADSI (Активные директории)</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Philip Jespersen</div>
<p>Чтобы создавать пользовательские аккаунты в Windows на Delphi можно использовать ADSI (Active Directory Services Interface) от Microsoft. Вы думаете, что ADSI это новая примочка для Windows 2000 (судя по названию) , но оказывается ADSI доступна для всех платформ Win32. Для этого Вам потребуется всего навсего скачать ADSI для Windows (более полная информация на http://www.microsoft.com/adsi ). Ну и конечно же ADSI входит в поставку Windows 2000.</p>
<p>ADSI довольно большой предмет для изучения. В данном примере я затрону этот предмет поверхностно. ADSI - это своего рода основа для различных сервисов (обычно основанных на директориях) оперционной системы. Например, стандартными ADSI сервисами можно назвать (COM интерфейсы, которые можно использовать в программах)  WinNT, IIS, LDAP и NDS. WinNT сервис может тем самым использоваться для создания пользовательских аккаунтов, модификации их или модификации групп.</p>
<p>Следующий небольшой пример показывает необходимые шаги для создания пользовательского аккаунта в NT/2000, используя ADSI:</p>
<p>Во первых Вам прийдётся импортировать Библиотеку Типов ADSI (Menu Project/Import Type Library). Библиотеку Типов можно найти в поддирректории system32 (Например C:\WINNT\system32\activeds.tlb). Требуемый файл называется 'activeds.tlb'. Если такого файла нет, то проверьте, правильно ли вы установили ADSI. После успешного импортирования Библиотеки Типов Вы найдёте новый файл в дирректории ипортов Delphi, файл будет называться "activeds_tlb.pas" (..\Delphi5\Imports\activeds_tlb.pas). Чтобы приступить к программированию ADSI в Delphi, необходимо включить этот файл в Ваш проект.</p>
<p>Далее в примере, необходимо заменить [computername] на фактическое имя компьютера, с которым Вы работаете. То же надо проделать с [accountname]. Пример тестировался на WindowsNT 4.0 и Windows 2000.</p>
<pre>
... 
 
uses ActiveX,        // используется для COM Moniker stuff... 
     ActiveDs_TLB,   // созданная библиотека типов 
     ComObj;         // используется для OleCheck и других функций COM 
 
implementation 
 
procedure TForm1.BtnCreateUserClick(Sender: TObject); 
var 
  Usr:  IADsUser; 
  Comp: IADsContainer; 
begin 
  try 
    Comp := GetObject('WinNT://[computername],computer') as 
      IADsContainer; 
    Usr := Comp.Create('user', '[accountname]') as IADsUser; 
    Usr.SetInfo; 
  except 
    on E: EOleException do begin 
      ShowMessage(E.Message); 
    end; 
  end; 
end; 
 
 
procedure TForm1.BtnSetPasswordClick(Sender: TObject); 
var 
  Usr: IADsUser; 
begin 
  try 
    Usr := GetObject('WinNT://[computername]/[accountname],user') 
      as IADsUser; 
    Usr.SetPassword('thenewpassword'); 
  except 
    on E: EOleException do begin 
      ShowMessage(E.Message); 
    end; 
  end; 
end; 
 
 
// GetObject использует вызов VB GetObject 
// Данный код (GetObject) был найден в Usenet.   
// 
// GetObject позволяет связаться с существующим ADSI сервисом 
// используя 'ADSIPath' (например WinNT://.... или 
// IIS://localhost). 
 
function TForm1.GetObject(const Name: string): IDispatch; 
var 
  Moniker: IMoniker; 
  Eaten: integer; 
  BindContext: IBindCtx; 
  Dispatch: IDispatch; 
begin 
  OleCheck(CreateBindCtx(0, BindContext)); 
  OleCheck(MkParseDisplayName(BindContext, 
                              PWideChar(WideString(Name)), 
                              Eaten, 
                              Moniker)); 
  OleCheck(Moniker.BindToObject(BindContext, NIL, IDispatch, 
            Dispatch)); 
 
  Result := Dispatch; 
end; 
 
end. 
</pre>

<p>Через ADSI Вы так же можете изменять параметры пользовательских аккаунтов. Следующий код изменяет флаг 'Password never expires' нужного аккаунта:</p>
<pre>
procedure TFormMain.ButtonNeverExpiresClick(Sender: TObject); 
var 
  Usr: IADsUser; 
begin 
  try 
    Usr := GetObject('WinNT://[computername]/[acccoutname],user') as 
      IADsUser; 
 
  // Проверяем состояние чекбоксов... 
  if CheckBoxPasswordNeverExpires.Checked then 
    Usr.Put('UserFlags', Usr.Get('UserFlags') OR 65536) 
    // 65536 объявлено как UF_DONT_EXPIRE_PASSWORD в iads.h   
    // в ADSI SDK от Microsoft 
  else 
    Usr.Put('UserFlags', Usr.Get('UserFlags') XOR 65536);   
    Usr.SetInfo; 
 
  except 
    on E: EOleException do begin 
      ShowMessage(E.Message); 
    end; 
  end; 
end; 
</pre>

<p>В завершении...</p>
<p>Чтобы использовать большие возможности ADSI , необходимо проверить, поддерживаются ли такие сервисы как IADsUser или IADsContainer.</p>
<p>Я рекомендую поработать с ADSI SDK от Microsoft и более детально изучить Библиотеку Типов.</p>
<p>Некоторые ADSI компоненты я постараюсь выложить на своей домашней страничке (http://www.jespersen.ch). Так что, если интересно, то заходите и мыльте на philip@jespersen.ch</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
