<h1>Как сделать procedure / function с переменным числом параметров?</h1>
<div class="date">01.01.2007</div>


<pre>
{ .... }
 
type
  VA_FN = function(const par1, par2{, ...}: Pointer): Boolean;
                   cdecl varargs;
 
{ .... }
 
//
// varargs without "external" keyword
//
function fn(const par1, par2{, ...}: Pointer): Boolean; cdecl;
var
  last_arg: Pointer absolute par2;
  ptr_args: array[0..MAXLONG shr 2] of Pointer absolute last_arg;
  dw_args: array[0..MAXLONG shr 2] of Cardinal absolute last_arg;
  s_args: array[0..MAXLONG shr 2] of PChar absolute last_arg;
  w_args: array[0..MAXLONG shr 2] of WideString absolute last_arg;
begin
  // ptr_args[1] is first optional argument
  Result := (ptr_args[1] {par3} = Pointer(1)) and
    (dw_args[2] {par4} = 2) and
    (string(ptr_args[3]) = 'CHAR') and
    (w_args[4] = 'WCHAR');
end;
 
procedure test_fn;
begin
  // VA_FN typecast
  VA_FN(@fn)({par1}nil, {par2}nil, {par3}Pointer(1), {par4}2, {par5}'CHAR',
    {par6}WideString('WCHAR'));
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
