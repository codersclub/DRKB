---
Title: Для своего браузера, как мне сохранить свои cookies?
Date: 01.01.2007
---


Для своего браузера, как мне сохранить свои cookies?
====================================================

::: {.date}
01.01.2007
:::

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



А вот пример странички:

    <!-- This document was created with HomeSite v2.0 -->
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
    <HTML>
    <HEAD>
       <TITLE>Delphi 4 Developer's Guide Cookie Setting and Retreiving Example</TITLE>
    </HEAD>
    <BODY BGCOLOR="Silver">
    <FONT SIZE="+1"><FONT SIZE="+1"><FONT COLOR="Red"><B>Delphi 4 Developer's Guide - Cookie Example</B></FONT></FONT></FONT>
    <P>
    The following links set and get a cookie onto your browser<P>
    <A HREF="../bin/cookie.dll/cookie">Click Here</A> to set the cookies
    <P>
    <A HREF="../bin/cookie.dll/getcookie">Click Here</A> to get cookie.
    </BODY>
    </HTML>



© Delphi 4 Developer\'s Guide

Взято из <https://forum.sources.ru>
