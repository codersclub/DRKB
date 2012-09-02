<h1>Метод Ньютона</h1>
<div class="date">01.01.2007</div>


<pre>
program newton;
type
vect1 = array [1..15] of real;
vect2 = array [1..15] of char;
vect3 = array [1..15] of integer;
var
coef,ncoef :vect1;
cha:vect2;bol:boolean;
pui:vect3;
b1,n,i,deg,l,nbr,ln,gen,k:integer;
s,p,c,x,y,z,r,d,ep,fd,x0,a,b :real;
co,rep:char;op,op1: set of char;
ch:string;
ca:char;
(*fonction de la puissance*)
function pow(x:real;n:integer):real;
 begin
    p:=1;
 
      for i := 1 to abs(n) do begin
                            if n &lt; 0 then p:=p/10
                                   else p:=p*x;
                              end;
    pow:=p;
 end;
(****************)
function chifi(chifr:char):integer;
 begin
   case chifr of
   '1':chifi:=1;'2':chifi:=2;'3':chifi:=3;'4':chifi:=4;'5':chifi:=5;
   '6':chifi:=6;'7':chifi:=7;'8':chifi:=8;'9':chifi:=9;'0':chifi:=0;
  end;
 end;
(*fonction qui lit la chaine de caractSre*)
function cach(chaine:string):real;
var  res:real;
    point,j:integer;
 begin
  b1:=0;
  for i:=1 to length(chaine) do if chaine[i]='.'then b1:=1;
   if b1 = 0 then chaine:=chaine+'.';
    if (chaine[1]&lt;&gt;'+') and (chaine[1]&lt;&gt;'-')then chaine:='+'+chaine;
  point:=length(chaine)+1;
  j:=1;
    for i:=2 to length(chaine) do begin
             if chaine[i]='.'then point:=i
                             else begin cha[j]:=chaine[i];j:=j+1;end;
                                  end;
    for i:=1 to length(chaine)-2 do begin
     case cha[i] of
      '1':ncoef[i]:=1;'2':ncoef[i]:=2;'3':ncoef[i]:=3;'4':ncoef[i]:=4;'5':ncoef[i]:=5;
      '6':ncoef[i]:=6;'7':ncoef[i]:=7;'8':ncoef[i]:=8;'9':ncoef[i]:=9;'0':ncoef[i]:=0;
     end;
    end;
 res:=0;
 j:=0;
  for l:=point-2 downto 1 do begin
                            res:= res + ncoef[l] * pow(10,j);
                            j:=j+1;
                             end;
 j:=1;
  for l:=point-1 to length(chaine)-2 do begin
                                  res:= res + ncoef[l] * pow(10,-j);
                                  j:=j+1;
                                         end;
   case chaine[1] of
    '+':res:=+1*res;
    '-':res:=-1*res;
   end;
  cach:=res;
 end;
(*procedure qui affiche la formule *)
procedure tri(st:string);
var l,di:integer;
    mot,mots,chifre:string;
 begin
  op1:=['0','1','2','3','4','5','6','7','8','9'];
  ln:=1;op:=['+','-','='];
  st:=st+'='+'0';
     if st[1] in op then else
       st:='+'+st;
         for l:=1 to length(st) do begin
             if l=1 then mot :=st[l]
                    else mot:=mot+st[l];
             if (st[l]in op) and (st[l+1]='x')then
              mot:=mot+'1';
               if (st[l+1]in op) and (st[l]='x')then
                 mot:=mot+'1';
                                    end;
   mots:=mot[1];
   for l:=2 to length(mot)-2 do mots:=mots+mot[l];
   st:=mot;writeln('l"‚quation est:   [ ', mots,'=0 ]');
    l:=1;
     while st[l] &lt;&gt; '=' do
      begin
       chifre:=st[l];
        while (st[l+1]&lt;&gt;'x')and(st[l+1]&lt;&gt;'=') do
        begin
          l:=l+1;
          chifre:=chifre+st[l];
        end;
      coef[ln]:=cach(chifre);ln:=ln+1;
      case st[l+1] of
        '=':l:=l+1;
        'x':begin
            pui[ln-1]:=chifi(st[l+2]);
            l:=l+3;
           end;
      end;
    end;
end;
(*foction qui calcule f(x)*)
function f(r:real):real;
 begin
   c:=0;
    case gen of
         4:for l:=1 to ln-1 do c:= c + coef[l] * pow(r,(pui[l]));
    end;
   f := c;
 end;
{*fonction qui calcule la 1er deriv‚*}
function df(var x:real):real;
 begin
  c:=0;
    case gen of
         4:for l:=1 to ln-2  do c:=c+pui[l] * coef[l] * pow(x,(pui[l]-1));
    end;
   df:=c;
 end;
 {*fonction qui calcule la 2eme deriv‚*}
function df2(var x:real):real;
 begin
   c:=0;
    case gen of
         4:for l:=1 to ln-3 do c:=c+pui[l]*(pui[l]-1)*coef[l]*pow(x,(pui[l]-2));
    end;
  df2:=c;
 end;
{*programme principale*}
begin
 rep:='n'; b1:=2;
 while rep&lt;&gt;'o' do
  begin
  writeln('PROGRAMME DE LA SOLUTION D"UNE FONCTION NON LINEAIRE PAR LA METHODE DE NEWTON');writeln('       ');
  writeln('* * * * * * * * * PRESENTE PAR BACHIR ET SAMIA * * * * * * * ');writeln;
  if b1&lt;&gt;2 then readln;
  writeln('        POUR CALCULER LA RACINE DE LA FONCTION: ');writeln('');
  write('        donner f[x]=');readln(ch);
   case ch[1] of
        '1'..'9','+','-','x':begin gen:=4; tri(ch); end;
   end;
   begin
      readln;
      write('donner la valeur a=');readln(a);
      write('donner la valeur b=');readln(b);
      write('donner l"erreur ep=');readln(ep);writeln(''); k:=0;
      if f(a)=0 then begin writeln(' SOLUTION x=',a);
                     writeln('  f[',a,']=',f(a));
                     writeln('ET LE NOMBRE D"ETERATION EST i=0');
                     end
                else if f(b)=0 then begin writeln(' SOLUTION x=',b);
                                    writeln('  f[',b,']=',f(b));
                                    writeln('ET NOMBRE D"ETERATION EST i=0');
                                    end
                               else
                                if f(a)*f(b)&gt;0 then begin
                                writeln('      ***************REMARQUE***************        ');
                                writeln('ERREUR!!! LA FONCTION NE ADMET AUCUN ZERO...');end
                                               else  begin
                                                 if f(a)*df2(a)&gt;0 then x0:=a
                                                                  else x0:=b;
                           if f(x0)=0 then begin r:=x0;
                           writeln('     SOLUTION x=',r);
                           writeln('  f[',r,']=',f(r));
                           writeln(' ET LE NOMBRE D"ITERATION EST i=',k); end
                                     else begin
                           if df(x0)=0 then begin
                           writeln('      ***************REMARQUE***************        ');
                           writeln('ERREUR!!! la derive est NULLE df(x)=0...');end
                                       else begin repeat
                                                  d:=-f(x0)/df(x0);
                                                  x0:=x0+d;
                                                  k:=k+1;
                                                 until abs(d)&lt;abs(ep*x0);
                                       r:=x0;
    writeln('                                          ');
    writeln('                 SOLUTION x=',r);
    writeln('                                          ');
    writeln('             f[',r,']=',f(r) );
    writeln('                                          ');
    writeln('                          ET                  ');
    writeln('                                         ');
    writeln('                  LE NOMBRE D"ITERATUION EST N=',k);
    writeln('                                          '); end;end;end;
    write('voulez vous quiter O/N?'); read(rep);
    writeln('                                         ');
    writeln('                                          ');
    writeln('                                          ');
    writeln('                                 ');
end;end;
end.
</pre>

