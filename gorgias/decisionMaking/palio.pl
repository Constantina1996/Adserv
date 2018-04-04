
rule(p-ihg(ad,X),prefer(pihg(ad,X),pi(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ihg(ad,X),prefer(pihg(ad,X),pih(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ihg(ad,X),prefer(pihg(ad,X),pig(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ihg(ad,X),prefer(pihg(ad,X),pg(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ihg(ad,X),prefer(pihg(ad,X),ph(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ihg(ad,X),prefer(pihg(ad,X),phg(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.


rule(p-ig(ad,X),prefer(pig(ad,X),pi(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ig(ad,X),prefer(pig(ad,X),pih(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ig(ad,X),prefer(pig(ad,X),pg(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ig(ad,X),prefer(pig(ad,X),ph(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ig(ad,X),prefer(pig(ad,X),phg(ad,I)),[]):-policy(3),adList(Z),member(X,Z),member(I,Z),X=\=I.


rule(p-ih(ad,X),prefer(pih(ad,X),pi(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ih(ad,X),prefer(pih(ad,X),pig(ad,I)),[]):-policy(P),(P==1;P==2),adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ih(ad,X),prefer(pih(ad,X),pg(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ih(ad,X),prefer(pih(ad,X),ph(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-ih(ad,X),prefer(pih(ad,X),phg(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.


rule(p-i(ad,X),prefer(pi(ad,X),pg(ad,I)),[]):-policy(P),[p;adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-i(ad,X),prefer(pi(ad,X),ph(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.

rule(p-i(ad,X),prefer(pi(ad,X),phg(ad,I)),[]):-adList(Z),member(X,Z),member(I,Z),X=\=I.
