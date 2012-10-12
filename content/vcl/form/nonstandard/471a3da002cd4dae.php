<h1>Как сделать форму без Caption?</h1>
<div class="date">01.01.2007</div>


<p>Обычная форма:</p>
<pre>
TForm.Style:=bsNone 
</pre>

<p class="author">Автор: Song</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>MDIChild форма:</p>
<pre>
setWindowLong (handle,GWL_STYLE,getWindowLong(handle, GWL_STYLE) and not WS_CAPTION);
width:=width+1;
width:=width-1;
</pre>

<p class="author">Автор: rhf </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
{ Private Declaration } 
procedure CreateParams(var Params : TCreateParams); override; 
 
... 
 
procedure TForm1.CreateParams(var Params : TCreateParams); 
 
begin 
inherited Createparams(Params); 
with Params do 
Style := (Style or WS_POPUP) and not WS_DLGFRAME; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
procedure TForm1.HideTitlebar; 
var 
  Style: Longint; 
begin 
  if BorderStyle = bsNone then Exit; 
  Style := GetWindowLong(Handle, GWL_STYLE); 
  if (Style and WS_CAPTION) = WS_CAPTION then 
  begin 
    case BorderStyle of 
      bsSingle, 
      bsSizeable: SetWindowLong(Handle, GWL_STYLE, Style and 
          (not (WS_CAPTION)) or WS_BORDER); 
      bsDialog: SetWindowLong(Handle, GWL_STYLE, Style and 
          (not (WS_CAPTION)) or DS_MODALFRAME or WS_DLGFRAME); 
    end; 
    Height := Height - GetSystemMetrics(SM_CYCAPTION); 
    Refresh; 
  end; 
end; 
 
procedure TForm1.ShowTitlebar; 
var 
  Style: Longint; 
begin 
  if BorderStyle = bsNone then Exit; 
  Style := GetWindowLong(Handle, GWL_STYLE); 
  if (Style and WS_CAPTION) &lt;&gt; WS_CAPTION then 
  begin 
    case BorderStyle of 
      bsSingle, 
      bsSizeable: SetWindowLong(Handle, GWL_STYLE, Style or WS_CAPTION or 
          WS_BORDER); 
      bsDialog: SetWindowLong(Handle, GWL_STYLE, 
          Style or WS_CAPTION or DS_MODALFRAME or WS_DLGFRAME); 
    end; 
    Height := Height + GetSystemMetrics(SM_CYCAPTION); 
    Refresh; 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  HideTitlebar; 
end; 
 
procedure TForm1.Button2Click(Sender: TObject); 
begin 
  ShowTitlebar; 
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

