<h1>Как имитировать появление формы как нового приложения?</h1>
<div class="date">01.01.2007</div>



<p>How i can create a form and this form stay in another icon in task bar ? (Looks like a new aplication).</p>

<p>In private clause:</p>
<pre>
type
  TForm1 = class(TForm)
  private
    { Private declarations }
    procedure CreateParams(var Params: TCreateParams); override;
</pre>
<p>And, in the implementation:</p>
<pre>
procedure TForm1.CreateParams(var Params: TCreateParams);
begin
  inherited CreateParams(Params);
  with params do
    ExStyle := ExStyle or WS_EX_APPWINDOW;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

