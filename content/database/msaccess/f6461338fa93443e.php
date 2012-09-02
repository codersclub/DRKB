<h1>Поверка версии Microsoft OLE DB JET 4.X</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Поверка версии Microsoft OLE DB JET 4.X
 
Функция определяет, установлен ли набор драйверов 
Microsoft OLE DB JET 4.X на компьютере. Пригодится 
для тех, кто использует СУБД Accsess. Можно 
использовать при инициализации главного DataModule, 
формы и т.д.
 
В принципе, функцию можно использовать для определения 
доступности любого поставщика данных : Oracle, MSSQL и т.д.
 
Функция работает намного быстрее, чем ADODB.GetProviderNames();
 
Зависимости: ADODB, ActiveX, OleDB
Автор:       Мироводин Дмитрий, support@hcsoft.spb.ru, Санкт - Петербург
Copyright:   Мироводин Дмитрий
Дата:        7 июля 2004 г.
********************************************** }
 
Function CheckMSJetVersion: Integer;
Const
  CLSID_JETOLEDB_4_00: TGUID = '{DEE35070-506B-11CF-B1AA-00AA00B8DE95}';
Var
  hR : HRESULT;
  OutParam : IUnknown;
Begin
  Result := -1;
  hR := CoCreateInstance(
    CLSID_JETOLEDB_4_00,
    Nil,
    CLSCTX_INPROC_SERVER,
    IID_IDBInitialize,
    OutParam);
 
  If (hR = S_OK) And (OutParam &lt;&gt; Nil) Then
    Begin
      OutParam := Nil;
      Result := 1;
    End;
End; 
</pre>

<p> Пример использования:</p>
<pre>
...
 
if (CheckMSJetVersion &lt; 0) then 
  begin
    ShowMessage('На машине не установлен MS Jet. ');
    Application.Terminate;
  end;
 
... 
</pre>

