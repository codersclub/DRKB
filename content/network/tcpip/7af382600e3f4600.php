<h1>Трассировка пути до определенного IP-адреса (Traceroute)</h1>
<div class="date">01.01.2007</div>


<p>Трассировка пути до определенного IP адреса (как tracert.exe в Windows)</p>
<p>Пример использования модуля:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var RT : TTraceRoute; 
begin 
 RT := TTraceRoute.Create; 
 RT.Trace('192.168.5.12', ListBox1.Items); 
 RT.Free; 
end; 
</pre>
<p>В ListBox1 выведется путь в таком формате:</p>
<p>IP;TIME;TTL;STATUS</p>
<p>Сам модуль:</p>
<pre>
unit TraceRt; 
interface 
 
// =========================================================================== 
// TRACEROUTE Class 
// Mike Heydon Dec 2003 
// 
// Method 
// Trace(IpAddress : string; ResultList : TStrings) 
//             Returns semi-colon delimited list of ip routes to target 
//             format .. IP ADDRESS; PING TIME MS; TIME TO LIVE; STATUS 
// 
// Properties 
//             IcmpTimeOut : integer (Default = 5000ms) 
//             IcmpMaxHops : integer (Default = 40) 
// =========================================================================== 
 
uses Forms, Windows, Classes, SysUtils, IdIcmpClient; 
 
type 
    TTraceRoute = class(TObject) 
    protected 
      procedure ProcessResponse(Status : TReplyStatus); 
      procedure AddRoute(AResponseTime : DWORD; 
                         AStatus: TReplyStatus; const AInfo: string ); 
    private 
      FIcmpTimeOut, 
      FIcmpMaxHops : integer; 
      FResults : TStringList; 
      FICMP : TIdIcmpClient; 
      FPingStart : cardinal; 
      FCurrentTTL : integer; 
      procedure PingTarget; 
    public 
      constructor Create; 
      procedure Trace(const AIpAddress : string; AResultList : TStrings); 
      property IcmpTimeOut : integer read FIcmpTimeOut write FIcmpTimeOut; 
      property IcmpMaxHops : integer read FIcmpMaxHops write FIcmpMaxHops; 
    end; 
 
// --------------------------------------------------------------------------- 
implementation 
 
// ======================================== 
// Create the class and set defaults 
// ======================================== 
 
constructor TTraceRoute.Create; 
begin 
 IcmpTimeOut := 5000; 
 IcmpMaxHops := 40; 
end; 
 
 
// ============================================= 
// Use Indy component to ping hops to target 
// ============================================= 
 
procedure TTraceRoute.PingTarget; 
var wOldMode : DWORD; 
begin 
 Application.ProcessMessages; 
 inc(FCurrentTTL); 
 
 if FCurrentTTL &lt; FIcmpMaxHops then begin 
   FICMP.TTL  := FCurrentTTL; 
   FICMP.ReceiveTimeout := FIcmpTimeOut; 
   FPingStart := GetTickCount; 
   wOldMode := SetErrorMode(SEM_FAILCRITICALERRORS); 
 
   try 
     FICMP.Ping; 
     ProcessResponse(FICMP.ReplyStatus); 
   except 
     FResults.Add('0.0.0.0;0;0;ERROR'); 
   end; 
 
   SetErrorMode(wOldMode); 
 end 
 else 
   FResults.Add('0.0.0.0;0;0;MAX HOPS EXCEEDED'); 
end; 
 
 
// ============================================================ 
// Add the ping reply status data to the returned stringlist 
// ============================================================ 
 
procedure TTraceRoute.AddRoute(AResponseTime : DWORD; 
                              AStatus: TReplyStatus; 
                              const AInfo: string ); 
begin 
 FResults.Add(AStatus.FromIPAddress + ';' + 
              IntToStr(GetTickCount - AResponseTime) + ';' + 
              IntToStr(AStatus.TimeToLive) + ';' + AInfo); 
end; 
 
 
// ============================================================ 
// Process the ping reply status record and add to stringlist 
// ============================================================ 
 
procedure TTraceRoute.ProcessResponse(Status : TReplyStatus); 
begin 
 case Status.ReplyStatusType of 
   // Last Leg - Terminate Trace 
   rsECHO : AddRoute(FPingStart,Status,'OK'); 
 
   // More Hops to go - Continue Pinging 
   rsErrorTTLExceeded :  begin 
                           AddRoute(FPingStart,Status,'OK'); 
                           PingTarget; 
                         end; 
 
   // Error conditions - Terminate Trace 
   rsTimeOut : AddRoute(FPingStart,Status,'TIMEOUT'); 
   rsErrorUnreachable : AddRoute(FPingStart,Status,'UNREACHABLE'); 
   rsError : AddRoute(FPingStart,Status,'ERROR'); 
 end; 
end; 
 
// ====================================================== 
// Trace route to target IP address 
// Results returned in semi-colon delimited stringlist 
// IP; TIME MS; TIME TO LIVE; STATUS 
// ====================================================== 
 
procedure TTraceRoute.Trace(const AIpAddress : string; 
                           AResultList : TStrings); 
begin 
 FICMP := TIdIcmpClient.Create(nil); 
 FICMP.Host := AIpAddress; 
 FResults := TStringList(AResultList); 
 FResults.Clear; 
 FCurrentTTL := 0; 
 PingTarget; 
 FICMP.Free; 
end; 
 
{eof} 
end. 
</pre>

<p class="author">Автор: p0s0l</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
