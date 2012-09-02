<h1>Лимит на время выполнения программы</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  In der Projekt Datei (.dpr): 
  In your project's file (.dpr): 
}
 
 uses
   Forms, Sysutils, Dialogs,
   MyProgr in my_prog1.pas {Form1};
 
 const
   email = 'my.mail@provider.xyz';
   homepage = 'http://www.myhomepage.com';
 
   // Limit the execution time to 04/21/2003. 
  // Gultigkeit auf 21. April 2003 begrenzen. 
 
  YearExp = 2003;
   MonthExp = 4;
   DayExp = 21;
 
 function CheckDate(y, m, d: Integer): Boolean;
 begin
   Result := True;
   if (Date &gt; EncodeDate(y, m, d)) then
   begin
     ShowMessage('End of usage exceeded. Download a new'+
                  'version at' + ^j + homepage+ ^j + ' or contact: ' + email);
   Result := False;
   // halt; 
end;
 
 end;
 
 
 {$R *.RES}
 
 begin
   if CheckDate(YearExp, MonthExp, DayExp) then
   begin
     Application.Initialize;
     Application.Title := 'Some Title';
     Application.CreateForm(TForm1, Form1);
     Application.Run;
   end;
 
 end.
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
