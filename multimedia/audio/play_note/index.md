---
Title: Как проиграть ноту?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как проиграть ноту?
===================

This is a simple class that plays a formatted musical string. It is
reminiscent of the old GWBASIC days whereby one could play a string of
notes via the PC speaker. I know that WAV and MIDI files are available
in todays technology, but sometimes one does not need all that overhead.
The class is useful for certain types of alarms (specially if the user
has his sound card volume muted) or simple "Cell Phone" like jingles.
The trick of the matter in Delphi is that the standard DELPHI
implementation of BEEP takes no arguments and has only one sound.
However the WIN API BEEP() takes two arguments.

ie.

    BOOL Beep(
         DWORD dwFreq,     // sound frequency, in hertz
         DWORD dwDuration  // sound duration, in milliseconds
        );

Parameters

- dwFreq

    - Windows NT: Specifies the frequency, in hertz, of the sound. This parameter   must
    be in the range 37 through 32,767 (0x25        through 0x7FFF).
    - Windows 95: The parameter is ignored.

- dwDuration

    - Windows NT: Specifies the duration, in milliseconds, of the sound.
    - Windows 95: The parameter is ignored.

As can be seen it appears that BEEP() is NOT supported on WIN95, but is
OK from there upwards. (I have not tested it on WIN95, but assume you
will just get a monotone ???? - anyone for comment)

It is easily called by prefixing the unit

ie. `Windows.Beep(Freq,Duration)`

The format of the "Music String" is a comma delimited (",\<" terminated)
string in the following formats.
(The string is CASE-INSENSITIVE and [] means optional with defaults).

    A..G[+ or -][0..5][/BEATS]

and

    @[/BEATS]

Where

- A..G   is the Note to be played.
- + or - is optional Sharp or Flat designator respectively.
  (default is normal NULL)
- 0..5   is optional Octave range (default = 1)
- /BEATS is number of 100ms to hold the note (default = 1)
- @ is a musical pause
- ,\<     is the END OF STRING terminator.

Properties:

- DefaultOctave: Used if no 0..5 designator specified in format. (System Default = 1)  
- BetweenNotesPause: Use to set number MS gap between notes (faster or slower default = 100ms)

Simple Example:

    procedure TForm1.Button3Click(Sender: TObject);
    var
      Organ: TMusicPlayer;
    begin
      Organ := TMusicPlayer.Create;
      Organ.Play('A,C,C+,D/3,C,A,C,A,@,F,D/4,<');
      Organ.Play('A,A3/2,G4,G/3,@/2,D-0/4,<');
      Organ.Free;
    end;

Any enhancements or additional ideas welcome. Happy jingeling.

    unit Music;
    interface
     
    uses Windows, SysUtils;
     
    // ===========================================================================
    // Mike Heydon May 2002
    // Simple Music Player Class Win98/2000 (Win95 not supported)
    // Implements Notes A,A#/Bb,C,C#/Db,D,D#,Eb,E,F,F#/Gb,G,G#/Ab
    // Caters for Octaves 0..5
    // In Between Note Pause setable.
    // Defailt Octave setable.
    //
    // Based on Frequency Matrix
    //
    //         Octave0   Octave1   Octave2   Octave3   Octave4   Octave5
    // A       55.000    110.000   220.000   440.000   880.000   1760.000
    // A#/Bb   58.270    116.541   233.082   466.164   932.328   1864.655
    // B       61.735    123.471   246.942   493.883   987.767   1975.533
    // C       65.406    130.813   261.626   523.251   1046.502  2093.005
    // C#/Db   69.296    138.591   277.183   554.365   1108.731  2217.461
    // D       73.416    146.832   293.665   587.330   1174.659  2349.318
    // D#/Eb   77.782    155.563   311.127   622.254   1244.508  2489.016
    // E       82.407    164.814   329.628   659.255   1318.510  2637.020
    // F       87.307    174.614   349.228   698.456   1396.913  2793.826
    // F#/Gb   92.499    184.997   369.994   739.989   1479.978  2959.955
    // G       97.999    195.998   391.995   783.991   1567.982  3135.963
    // G#/Ab   103.826   207.652   415.305   830.609   1661.219  3322.438
    //
    // @ = Pause
    // < = End of Music String Marker
    //
    // ===========================================================================
     
    type
      TOctaveNumber = 0..5;
      TNoteNumber = -1..11;
     
      TMusicPlayer = class(TObject)
      private
        Octave,
          FDefaultOctave: TOctaveNumber;
        NoteIdx: TNoteNumber;
        FBetweenNotesPause,
          Duration: integer;
      protected
        function ParseNextNote(var MS: string): boolean;
      public
        constructor Create;
        procedure Play(const MusicString: string);
        property DefaultOctave: TOctaveNumber read FDefaultOctave
          write FDefaultOctave;
        property BetweenNotesPause: integer read FBetweenNotesPause
          write FBetweenNotesPause;
      end;
     
      // ---------------------------------------------------------------------------
    implementation
     
    const
      MAXSTRING = 2048; // ASCIIZ String max length
     
      MHERTZ: array[0..11, 0..5] of integer = // Array of Note MHertz
      ((55, 110, 220, 440, 880, 1760), // A
        (58, 117, 233, 466, 932, 1865), // A+ B-
        (62, 123, 247, 494, 988, 1976), // B
        (65, 131, 262, 523, 1047, 2093), // C
        (69, 139, 277, 554, 1109, 2217), // C+ D-
        (73, 147, 294, 587, 1175, 2349), // D
        (78, 156, 311, 622, 1245, 2489), // D+ E-
        (82, 165, 330, 659, 1319, 2637), // E
        (87, 1745, 349, 698, 1397, 2794), // F
        (92, 185, 370, 740, 1480, 2960), // F+ G-
        (98, 196, 392, 784, 1568, 3136), // G
        (105, 208, 415, 831, 1661, 3322) // G+ A-
        );
     
      // =======================================
      // Create the object and set defaults
      // =======================================
     
    constructor TMusicPlayer.Create;
    begin
      FDefaultOctave := 1;
      FBetweenNotesPause := 100;
    end;
     
    // ===========================================================
    // Parse the next note and set Octave,NoteIdx and Duration
    // ===========================================================
     
    function TMusicPlayer.ParseNextNote(var MS: string): boolean;
    var
      NS: string; // Note String
      Beats,
        CommaPos: integer;
      Retvar: boolean;
    begin
      Retvar := false; // Assume Error Condition
      Beats := 1;
      Duration := 0;
      NoteIdx := 0;
      Octave := FDefaultOctave;
      CommaPos := pos(',', MS);
     
      if (CommaPos > 0) then
      begin
        NS := trim(copy(MS, 1, CommaPos - 1)); // Next Note info
        MS := copy(MS, CommaPos + 1, MAXSTRING); // Remove note from music string
     
        if (length(NS) >= 1) and (NS[1] in ['@'..'G']) then
        begin
          Retvar := true; // Valid Note - set return type true
     
          // Resolve NoteIdx
          NoteIdx := byte(NS[1]) - 65; // Map 'A'..'G' into 0..11 or -1
          NS := copy(NS, 2, MAXSTRING); // Remove the Main Note ID
     
          // Handle the @ Pause first
          if NoteIdx = -1 then
          begin
            if (length(NS) >= 1) and (NS[1] = '/') then
              Beats := StrToIntDef(copy(NS, 2, MAXSTRING), 1);
            Sleep(100 * Beats);
            Retvar := false; // Nothing to play
            NS := ''; // Stop further processing
          end;
     
          // Resolve Sharp or Flast
          if (length(NS) >= 1) and (NS[1] in ['+', '-']) then
          begin
            if NS[1] = '+' then // # Sharp
              inc(NoteIdx)
            else if NS[1] = '-' then // b Flat
              dec(NoteIdx);
     
            if NoteIdx = -1 then
              NoteIdx := 11; // Roll A Flat to G Sharp
            NS := copy(NS, 2, MAXSTRING); // Remove Flat/Sharp ID
          end;
     
          // Resolve Octave Number - Default := FDefaultOctave
          if (length(NS) >= 1) and (NS[1] in ['0'..'5']) then
          begin
            Octave := byte(NS[1]) - 48; // map '0'..'5' to 0..5 decimal
            NS := copy(NS, 2, MAXSTRING); // Remove Octave Number
          end;
     
          // Resolve Number of Beats - Default = 1
          if (length(NS) >= 1) and (NS[1] = '/') then
            Beats := StrToIntDef(copy(NS, 2, MAXSTRING), 1);
     
          Duration := 100 * Beats;
        end;
      end
      else
        MS := ''; // Signal end of music string
     
      Result := Retvar;
    end;
     
    // ===================================
    // Play the passed music string
    // ===================================
     
    procedure TMusicPlayer.Play(const MusicString: string);
    var
      MS: string; // Music String
    begin
      MS := trim(UpperCase(MusicString));
     
      while (MS <> '') do
      begin
        if ParseNextNote(MS) then
        begin
          Windows.Beep(MHERTZ[NoteIdx, Octave], Duration);
          Sleep(FBetweenNotesPause);
        end;
      end;
    end;
     
    end.

