<h1>Как присвоить событие в runtime?</h1>
<div class="date">01.01.2007</div>


<p>Пример стандартного присвоения события в run-time:</p>
<pre>
type

 
  TForm1 = class(TForm)
    Button1: TButton;
    procedure FormCreate(Sender: TObject);
  private
    procedure Click(Sender: TObject);
  end;
 
var  Form1: TForm1;
 
implementation
 
procedure TForm1.Click(Sender: TObject);
begin
  // do something
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  button1.OnClick:=Click;
end;
 
end.
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>А как сделать чтобы "procedure Click" была не методом класса, а отдельно стоящей функцией?</p>
<pre>

 
procedure Click(Self: TObject; Sender: TObject);
begin
  ...
end;
 
var
  evhandler: TNotifyEvent;
  TMethod(evhandler).Code := @Click;
  TMethod(evhandler).Data := nil;
  Button1.OnClick := evhandler;
 
  Без извращений можно так:
 
  TDummy = class
    class procedure Click(Sender: TObject);
  end;
 
  Button1.OnClick := TDummy.Click;
</pre>
<div class="author">Автор: Le Taon</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>По идее, при вызове OnClick первым параметром будет запихнут указатель на экземпляр того класса который в этом OnClick хранится . Я в низкоуровневой реализации не силен, но кажись, так как параметры в процедурах в Delphi передаются через регистры, то ничего страшного не произойдет.</p>
<pre>

procedure C(Self:pointer;Sender:TObject);
begin
  TButton(Sender).Caption:='ee';
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  @Button1.OnClick:=@c;
end;
</pre>
<p>Self тут у нас будет равен nil, а Sender как раз и получается Sender'ом.</p>
<div class="author">Автор: Fantasist</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

