<h1>Как убрать заголовок в дочерней форме MDI?</h1>
<div class="date">01.01.2007</div>


<p>Если в дочерней форме MDI установить BorderStyle в bsNone, то заголовок формы не исчезнет. (Об этом сказано в хелпе). А вот следующий пример решает эту проблему:</p>
<pre>
type
  ... = class(TForm)
{ other stuff above }
    procedure CreateParams(var Params: TCreateParams); override;
{ other stuff below }
  end;
 
  ...
 
procedure tMdiChildForm.CreateParams(var Params: tCreateParams);
begin
  inherited CreateParams(Params);
  Params.Style := Params.Style and (not WS_CAPTION);
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />
<pre>
type
  TForm2 = class(TForm)
    { другой код выше }
    procedure CreateParams(var Params: TCreateParams); override;
    { другой код ниже }
  end;
 
procedure TForm2.CreateParams(var Params: TCreateParams);
begin
  inherited CreateParams(Params);
  Params.Style := Params.Style and not WS_OVERLAPPEDWINDOW or WS_BORDER
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

