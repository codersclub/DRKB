<h1>Как получить POST-данные?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm</p>

<p>Если данные передаются в формате 'animal=cat&amp; color=brown' и т.д.,</p>
<p>то попробуйте использовать следующий код:</p>
<pre>
procedure TDBModule.Navigate(stURL, stPostData: String; var wbWebBrowser: TWebBrowser);
var
  vWebAddr, vPostData, vFlags, vFrame, vHeaders: OleVariant;
  iLoop: Integer;
begin
{Are we posting data to this Url?}
if Length(stPostData)&gt; 0 then
begin
{Require this header information if there is stPostData.}
vHeaders:= 'Content-Type: application/x-www-form-urlencoded'+ #10#13#0;
{Set the variant type for the vPostData.}
vPostData:= VarArrayCreate([0, Length(stPostData)], varByte);
for iLoop := 0 to Length(stPostData)- 1 do // Iterate
begin
  vPostData[iLoop]:= Ord(stPostData[iLoop+ 1]);
end; // for
{Final terminating Character.}
vPostData[Length(stPostData)]:= 0;
{Set the type of Variant, cast}
TVarData(vPostData).vType:= varArray;
end;
{And the other stuff.}
vWebAddr:= stURL;
{Make the call Rex.}
wbWebBrowser.Navigate2(vWebAddr, vFlags, vFrame, vPostData, vHeaders);
end; {End of Navigate procedure.}
</pre>

<div class="author">Автор: Craig Foley Ответ: А это другой способ:</div>
<pre>
procedure TForm1.SubmitPostForm;
var
strPostData: string;
Data: Pointer;
URL, Flags, TargetFrameName, PostData, Headers: OleVariant;
begin
{
&lt; !-- submit this html form: --&gt;
&lt; form method=" post" action=" http://127.0.0.1/cgi-bin/register.pl" &gt;
&lt; input type=" text" name=" FIRSTNAME" value=" Hans" &gt;
&lt; input type=" text" name=" LASTNAME" value=" Gulo" &gt;
&lt; input type=" text" name=" NOTE" value=" thats it" &gt;
&lt; input type=" submit" &gt;
&lt; /form&gt;
}
strPostData := 'FIRSTNAME=Hans&amp; LASTNAME=Gulo&amp; NOTE=thats+it';
PostData := VarArrayCreate([0, Length(strPostData) - 1], varByte);
Data := VarArrayLock(PostData);
try
  Move(strPostData[1], Data^, Length(strPostData));
finally
  VarArrayUnlock(PostData);
end;
URL := 'http://127.0.0.1/cgi-bin/register.pl';
Flags := EmptyParam;
TargetFrameName := EmptyParam;
Headers := EmptyParam; // TWebBrowse
// эти заголовки соответствующими зна?ениями
WebBrowser1.Navigate2(URL, Flags, TargetFrameName, PostData, Headers);
end;
</pre>

<div class="author">Автор: Hans Gulo.</div>

<hr />в BeforeNavigate2, если посмотреть на PostData, увидем строку типа "????????", а как нормальную получить ?</p>
<pre>
function VariantArrayToStream(VarArray: OleVariant): TStream;
var
  pLocked: Pointer;
begin
  Result:= TMemoryStream.Create;
  if VarIsEmpty(VarArray) or VarIsNull(VarArray) then Exit;
  Result.Size := VarArrayHighBound(VarArray, 1) - VarArrayLowBound(VarArray, 1) + 1;
  pLocked := VarArrayLock(VarArray);
  try
    Result.Write(pLocked^, Result.Size);
  finally
    VarArrayUnlock(VarArray);
    Result.Position := 0;
  end;
end;
 
procedure TForm1.WebBrowser1BeforeNavigate2(Sender: TObject;
  const pDisp: IDispatch; var URL, Flags, TargetFrameName, PostData,
  Headers: OleVariant; var Cancel: WordBool);
var
  stream: TStream;
begin
  stream:= VariantArrayToStream(PostData);
  try
    Memo1.Lines.LoadFromStream(stream);
  finally
    stream.Free;
  end;
end;
</pre>

<div class="author">Автор: Alex</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

