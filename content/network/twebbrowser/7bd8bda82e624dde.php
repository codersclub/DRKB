<h1>Для своего браузера, как мне сохранить свои cookies?</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, HTTPApp, WebUtils;
 
type
  TWebModule1 = class(TWebModule)
    procedure WebModule1WebActionItem1Action(Sender: TObject;
      Request: TWebRequest; Response: TWebResponse; var Handled: Boolean);
    procedure WebModule1WebActionItem2Action(Sender: TObject;
      Request: TWebRequest; Response: TWebResponse; var Handled: Boolean);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  WebModule1: TWebModule1;  
 
implementation
 
{$R *.DFM}
 
 
procedure TWebModule1.WebModule1WebActionItem1Action(Sender: TObject;
  Request: TWebRequest; Response: TWebResponse; var Handled: Boolean);
var
  List: TStringList;
begin
  List := TStringList.Create;
  try
     List.Add('LastVisit=' + FormatDateTime('mm/dd/yyyy hh:mm:ss', Now));
     Response.SetCookieField(List, '', '', Now + 10, False);
     Response.Content := 'Cookie set -- ' + Response.Cookies[0].Name;
  finally
    List.Free;
  end;
  Handled := True;
end;
 
procedure TWebModule1.WebModule1WebActionItem2Action(Sender: TObject;
  Request: TWebRequest; Response: TWebResponse; var Handled: Boolean);
var
  Params: TParamsList;
begin
     Params := TParamsList.Create;
     try
       Params.AddParameters(Request.CookieFields);
       Response.Content := 'You last set the cookie on ' + Params['LastVisit'];
     finally
       Params.Free;
     end;
end;
 
end.
</pre>
<p> <br>
<p>А вот пример странички:</p>
<pre>&lt;!-- This document was created with HomeSite v2.0 --&gt;
&lt;!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN"&gt;
&lt;HTML&gt;
&lt;HEAD&gt;
   &lt;TITLE&gt;Delphi 4 Developer's Guide Cookie Setting and Retreiving Example&lt;/TITLE&gt;
&lt;/HEAD&gt;
&lt;BODY BGCOLOR="Silver"&gt;
&lt;FONT SIZE="+1"&gt;&lt;FONT SIZE="+1"&gt;&lt;FONT COLOR="Red"&gt;&lt;B&gt;Delphi 4 Developer's Guide - Cookie Example&lt;/B&gt;&lt;/FONT&gt;&lt;/FONT&gt;&lt;/FONT&gt;
&lt;P&gt;
The following links set and get a cookie onto your browser&lt;P&gt;
&lt;A HREF="../bin/cookie.dll/cookie"&gt;Click Here&lt;/A&gt; to set the cookies
&lt;P&gt;
&lt;A HREF="../bin/cookie.dll/getcookie"&gt;Click Here&lt;/A&gt; to get cookie.
&lt;/BODY&gt;
&lt;/HTML&gt;
</pre>
<p> <br>
<p>&#169; Delphi 4 Developer's Guide</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
