check-price(B):-adList(Z),check(B,Z).

check(B,[]).

check(B,[Z|Zs]):-ad(B,_,P1,_),ad(Z,_,P2,_),B=\=Z,ad(Z,_,P2,_)->P1>=P2,check(B,Zs);
                                           check(B,Zs).
%%%%%%%%%%%%%%%%%%%%%%%%%%% POLICY 2 %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

%%%%%%% 100 KOINO PREFER ADS WITH USER INTERESTS THAN USER GEOGRAPGY %%%%%%%%%%%%%%%%%%

rule(pi(ad,X), prefer(i(ad,X),g(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 101 KOINO PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(pig(ad,X), prefer(ig(ad,X),i(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 101 KOINO PREFER ADS WITH USER INTERESTS AND GEOGRAPHY THAN USER GEOGRAPHY ONLY %%%%%%%%%%%%%%%%%%

rule(pig(ad,X), prefer(ig(ad,X),g(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 010 PREFER ADS WITH HIGHPRICE THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(ph(ad,X), prefer(h(ad,X),i(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% KOINO 010 PREFER ADS WITH HIGHPRICE THAN USER GEOGRAPHY ONLY %%%%%%%%%%%%%%%%%%

rule(ph(ad,X), prefer(h(ad,X),g(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 010 PREFER ADS WITH HIGHPRICE THAN USER INTERESTS AND GEOGRAPHY  %%%%%%%%%%%%%%%%%%

rule(ph(ad,X), prefer(h(ad,X),ig(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.



%%%%%%% KOINO 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN USER GEOGRAPHY ONLY %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),g(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN USER INTERESTS ONLY %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),i(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% KOINO 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN HIGHPRICE ONLY %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),h(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.


%%%%%%% 011 PREFER ADS WITH HIGHPRICE AND USER GEOGRAPHY THAN USER INTERESTS AND GEOGRAPHY %%%%%%%%%%%%%%%%%%

rule(phg(ad,X), prefer(hg(ad,X),ig(ad,I)),[]):-policy(2),adList(Z),member(X,Z),member(I,Z),X=\=I.

