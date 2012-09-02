<h1>Как сделать, чтобы неглавная форма минимизировалась не на Taskbar, а выше него?</h1>
<div class="date">01.01.2007</div>


<pre>
void __fastcall CreateParams(TCreateParams &amp;Params);
 
...
 
void __fastcall TForm1::CreateParams(TCreateParams &amp;Params)
{
TForm::CreateParams(Params);
Params.ExStyle |= WS_EX_APPWINDOW;
Params.WndParent = GetDesktopWindow();
}
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
