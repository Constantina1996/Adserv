Predicates for visualizing argument trees
=========================================
%% extensions to Gorgias by Nick Bassiliades

-----------------------------------
visual_prove(+Goal,-Delta,+Options)
-----------------------------------
Works exactly like prove(Goal, Delta), i.e. returns Delta for a given Goal, 
but also pretty prints the argument tree.
This is a backtrackable predicate.
Options is a list of options for controlling the visualization of argument trees.
Currently there is only one option: failed(true/false) which controls
if failed arguments will be printed or not. 
When failed(true), if there are failed attempts to prove the Goal,
then the predicate will print them too, returning 'FAIL' as the Delta.
When failed(false) or the option is absent, then only successfull (proven)
arguments will be pretty printed.

--------------------------
visual_prove(+Goal,-Delta)
--------------------------
Equivalent to visual_prove(+Goal,-Delta, []).

--------------------------------
visual_prove_all(+Goal,+Options)
--------------------------------
Pretty prints all alternative Deltas and 
corresponding argument trees for a given Goal.
Non-backtrackable predicate.
Options is similar to visual_prove/3.

--------------------------------
visual_prove_all(+Goal,+Options)
--------------------------------
Equivalent to visual_prove_all(+Goal, []).

-------------------------------------------
visual_prove_string(+Goal,-String,+Options)
-------------------------------------------
Returns in string String all that visual_prove_all/2 (see above) prints.
Non-backtrackable predicate.
Options is similar to visual_prove/3.

----------------------------------
visual_prove_string(+Goal,-String)
----------------------------------
Equivalent to visual_prove_string(+Goal,-String,[]).

---------------
Usage examples
---------------
(using the penguin.pl example)

?- visual_prove([fly(X)],A).

[f1, r1(t)]
|___[r2(t), f2, r3(t), pr1]
    |___[r4(t), f3, pr2]

X = t,
A = [r4(t),f3,pr2,f1,r1(t)].

?- visual_prove([fly(X)],A,[failed(true)]).

[f2, r3(t), r5(t), r1(t)]
|___[r4(t), f3, pr2]
|   |___NO COUNTERATTACK
|___[r2(t), f2, r3(t), pr1]
    |___NO COUNTERATTACK

X = t,
A = 'FAIL' ;

[f1, r1(t)]
|___[r2(t), f2, r3(t), pr1]
    |___[r4(t), f3, pr2]

X = t,
A = [r4(t),f3,pr2,f1,r1(t)].

?- visual_prove_all([fly(X)]).
Delta: [r4(t), f3, pr2, f1, r1(t)]
Tree: 
[f1, r1(t)]
|___[r2(t), f2, r3(t), pr1]
    |___[r4(t), f3, pr2]

true.

?- visual_prove([neg(fly(X))],A).
false.

?- visual_prove([neg(fly(X))],A,[failed(true)]).

[f2, r3(t), r2(t)]
|___[r4(t), f3, pr2]
    |___NO COUNTERATTACK

X = t,
A = 'FAIL' ;
false.

?- visual_prove_all([fly(X)],[failed(true)]).
Delta: FAIL
Tree: 
[f2, r3(t), r5(t), r1(t)]
|___[r4(t), f3, pr2]
|   |___NO COUNTERATTACK
|___[r2(t), f2, r3(t), pr1]
    |___NO COUNTERATTACK

Delta: [r4(t), f3, pr2, f1, r1(t)]
Tree: 
[f1, r1(t)]
|___[r2(t), f2, r3(t), pr1]
    |___[r4(t), f3, pr2]

true.

?- visual_prove_string([fly(X)],S).
S = '--------------------\nDelta=[r4(t), f3, pr2, f1, r1(t)]\n--------------------\n[f1, r1(t)]\n|___[r2(t), f2, r3(t), pr1]\n    |___[r4(t), f3, pr2]\n'.

?- visual_prove_string([fly(X)],S,[failed(true)]).
S = '---------------\nFAILED ARGUMENT\n---------------\n[f2, r3(t), r5(t), r1(t)]\n|___[r4(t), f3, pr2]\n|   |___NO COUNTERATTACK\n|___[r2(t), f2, r3(t), pr1]\n    |___NO COUNTERATTACK\n\n--------------------\nSUCCESSFULL ARGUMENT\nDelta=[r4(t), f3, pr2, f1, r1(t)]\n--------------------\n[f1, r1(t)]\n|___[r2(t), f2, r3(t), pr1]\n    |___[r4(t), f3, pr2]\n'.
