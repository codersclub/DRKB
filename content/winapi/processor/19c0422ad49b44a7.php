<h1>Поддерживает ли процессор технологию 3DNow?</h1>
<div class="date">01.01.2007</div>


<pre>
{$ifndef ver80} // так как будем использовать 32-битный регистр
    function 3DNowSupport: Boolean; assembler; 
    asm 
      push  ebx 
      mov   @Result, True 
      mov   eax, $80000000 
      dw    $A20F            
      cmp   eax, $80000000 
      jbe   @NOEXTENDED    // 3DNow не поддерживается
      mov   eax, $80000001 
      dw    $A20F            
      test  edx, $80000000 
      jnz    @EXIT          // 3DNow поддерживается
      @NOEXTENDED: 
      mov  @Result, False 
      @EXIT: 
      pop ebx 
    end; 
    {$endif}
</pre>

