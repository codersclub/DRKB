<h1>Первый CORBA сервер</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
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
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

