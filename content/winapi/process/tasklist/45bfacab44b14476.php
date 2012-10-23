<h1>Как активизировать предыдущий экземпляр вашей программы?</h1>
<div class="date">01.01.2007</div>


<p>Если внутренняя переменная hPrevInst не равна нулю, то она содержит дескриптор предыдущего запущенного экземпляра вашей программы. Вы просто находите открытое окно по его дескриптору и, при необходимости, выводите на передний план. Весь код расположен в файле .DPR file, НЕ в модуле. Строки, которые вам необходимо добавить к вашему .DPR-файлу, в приведенном ниже примере помечены {*}.</p>

<pre>
program Once;
 
uses
{*}  WinTypes, WinProcs, SysUtils,
 
Forms,
Onceu in 'ONCEU.PAS' {Form1};
 
{$R *.RES}
{*}TYPE
{*}  PHWND = ^HWnd;
 
{*}  FUNCTION EnumWndProc(H : hWnd; P : PHWnd) : Integer; Export;
{*}  VAR ClassName : ARRAY[0..30] OF Char;
{*}  BEGIN
{*}    {Если это окно принадлежит предшествующему экземпляру...}
{*}    IF GetWindowWord(H, GWW_HINSTANCE) = hPrevInst THEN
{*}      BEGIN
{*}        {... проверяем КАКОЕ это окно.}
{*}        GetClassName(H, ClassName, 30);
{*}        {Если это главное окно приложения...}
{*}        IF StrIComp(ClassName, 'TApplication') = 0 THEN
{*}          BEGIN
{*}            {... ищем}
{*}{*}            P^ := H;
{*}            EnumWndProc := 0;
{*}          END;
{*}      END;
{*}  END;
 
{*}  PROCEDURE CheckPrevInst;
{*}  VAR PrevWnd : hWnd;
{*}  BEGIN
{*}    IF hPrevInst &lt;&gt; 0 THEN
{*}      {Предыдущий экземпляр запущен}
{*}      BEGIN
{*}        PrevWnd := 0;
{*}        EnumWindows(@EnumWndProc, LongInt(@PrevWnd));
{*}        {Ищем дескриптор окна предыдущего}
{*}        {экземпляра и активизируем его}
{*}        IF PrevWnd &lt;&gt; 0 THEN
{*}          IF IsIconic(PrevWnd) THEN
{*}            ShowWindow(PrevWnd, SW_SHOWNORMAL)
{*}          ELSE BringWindowToTop(PrevWnd);
{*}        Halt;
{*}      END;
{*}  END;
begin
{*}  CheckPrevInst;
 
Application.Title := 'Once';
Application.CreateForm(TForm1, Form1);
Application.Run;
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

