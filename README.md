# Inkway — sites publiés

Publication GitHub Pages :

- `catalogue/` — 12 sites standards. Les clients reçoivent le lien de leur secteur uniquement : `catalogue/coiffure-homme/`, `coiffure-femme/`, `esthetique/`, `spa/` (avec `?salon=Nom`). La racine `catalogue/` n’affiche plus la liste complète (disponible dans l’espace de travail).
- `pken/` — landing page personnalisée de PKEN Coiffure (Alfortville), en attente de validation du gérant.

Pages statiques (HTML/CSS/JS sans dépendance). Toutes les pages portent `noindex` tant qu’elles ne sont pas validées. Photos des modèles : Unsplash.

## Page de choix des maquettes
`catalogue/choix/?salon=…&m1=/salon/maquette-1/&n1=…` affiche côte à côte les maquettes personnalisées d’un salon (jusqu’à 3, uniquement des pages de ce site) avec un bouton « Je choisis cette maquette » vers WhatsApp Inkway.

- Déploiement Vercel relié au dépôt GitHub (branche main) depuis le 9 novembre 2026 : chaque mise à jour de main est publiée automatiquement.
