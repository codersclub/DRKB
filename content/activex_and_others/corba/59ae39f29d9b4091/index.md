---
Title: Первый CORBA сервер
Date: 01.01.2007
---


Первый CORBA сервер
===================

::: {.date}
01.01.2007
:::

    unit uMyFirstCorbaServer;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, ComObj, StdVcl,
      CorbaObj, FirstCorbaServer_TLB;
     
    type
     
      TMyFirstCorbaServer = class(TCorbaImplementation, IMyFirstCorbaServer)
      private
        { Private declarations }
      public
        { Public declarations }
      protected
        procedure SayHelloWorld; safecall;
      end;
     
    implementation
     
    uses CorbInit;
     
    procedure TMyFirstCorbaServer.SayHelloWorld;
    begin
     
    end;
     
    initialization
      TCorbaObjectFactory.Create('MyFirstCorbaServerFactory', 'MyFirstCorbaServer',
        'IDL:FirstCorbaServer/MyFirstCorbaServerFactory:1.0', IMyFirstCorbaServer,
        TMyFirstCorbaServer, iMultiInstance, tmSingleThread);
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
