<<<<<<< HEAD
# FolioBR - Thème WordPress Portfolio

Un thème WordPress moderne et élégant conçu pour les portfolios professionnels. FolioBR offre une expérience utilisateur intuitive avec un design responsive et des fonctionnalités avancées pour mettre en valeur vos compétences et réalisations.

## 🌟 Caractéristiques

### Design & Interface

- Design responsive et moderne
- Mode sombre/clair avec persistance des préférences
- Animations et transitions fluides
- Curseur personnalisé interactif
- Chargeur de page élégant
- Interface utilisateur intuitive

### Gestion du Contenu

- **Section Présentation**

  - Titre et description personnalisables
  - Configuration via le panneau d'administration

- **Gestion des Compétences**

  - Type de contenu personnalisé pour les compétences
  - Barre de progression pour chaque compétence
  - Catégorisation des compétences
  - Mise en avant des compétences principales
  - Système de filtrage et tri

- **Gestion des Réalisations**
  - Portfolio de projets avec images
  - Catégorisation par type de projet et technologies
  - Association avec les compétences utilisées
  - Liens vers les projets
  - Année de réalisation et rôle tenu

### Réseaux Sociaux

- Intégration de multiples plateformes :
  - GitHub (avec support des icônes light/dark)
  - LinkedIn
  - Malt
  - LeHibou
  - Codeur
  - Upwork
  - ComeUp
  - Crème de la Crème
  - Freelance.com
  - Fiverr
  - Comet

### Fonctionnalités Techniques

- Support SVG natif
- Optimisation des performances
- Navigation fluide entre les sections
- Système de miniatures interactif
- Modal de contact intégré
- Shortcodes personnalisés
- Support multilingue
- Intégration avec Contact Form 7

## 📋 Prérequis

- WordPress 5.0 ou supérieur
- PHP 7.4 ou supérieur
- MySQL 5.6 ou supérieur
- Serveur Web Apache ou Nginx

## 🚀 Installation

1. Téléchargez le thème
2. Dans votre administration WordPress, allez dans Apparence > Thèmes
3. Cliquez sur "Ajouter" puis "Téléverser un thème"
4. Sélectionnez le fichier zip du thème
5. Activez le thème

## ⚙️ Configuration

### Réglages de Présentation

1. Dans le menu d'administration, allez dans "Présentation"
2. Configurez votre titre et votre description
3. Ajoutez et configurez vos réseaux sociaux

### Compétences

1. Ajoutez vos compétences via le menu "Compétences"
2. Définissez les catégories de compétences
3. Configurez le niveau de maîtrise avec la barre de progression
4. Sélectionnez les compétences à mettre en avant

### Réalisations

1. Créez vos réalisations via le menu "Réalisations"
2. Ajoutez les images, descriptions et liens
3. Associez les technologies et compétences utilisées
4. Définissez l'année et votre rôle

### Personnalisation

1. Utilisez le customizer WordPress pour :
   - Configurer les titres et descriptions des archives
   - Personnaliser les textes des liens
   - Ajuster les options d'affichage

## 🛠️ Développement

Pour contribuer au développement :

1. Clonez le dépôt

```bash
git clone https://github.com/votre-username/FolioBR.git
```

2. Installez les dépendances

```bash
npm install
```

3. Suivez les standards de code WordPress

### Structure des Fichiers

```
FolioBR/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── inc/
│   ├── Admin/
│   ├── Competences/
│   ├── Contact/
│   ├── Menu/
│   ├── Realisations/
│   ├── Shortcodes/
│   └── Utils/
└── template-parts/
```

## 📝 Licence

Ce thème est sous licence GPL v2 ou ultérieure

## 🤝 Support

Pour toute question ou support :

1. Consultez la documentation
2. Ouvrez une issue sur GitHub
3. Contactez-nous via le formulaire de contact

## 🔄 Mises à jour

Le thème est régulièrement mis à jour pour assurer :

- La compatibilité avec les dernières versions de WordPress
- L'ajout de nouvelles fonctionnalités
- Les corrections de bugs
- Les améliorations de sécurité

## 🌐 Liens Utiles

- [Documentation](https://votre-site.com/docs)
- [Démo en ligne](https://votre-site.com/demo)
- [Changelog](https://votre-site.com/changelog)

## ⚡ Shortcodes Disponibles

Le thème inclut plusieurs shortcodes puissants pour une mise en page flexible :

### Présentation

```
[front_presentation]
```

Affiche la section de présentation personnalisée avec :

- Le titre configuré dans les réglages
- La description personnalisée
- L'image de présentation par défaut

### Compétences

```
[front_competences]
```

Affiche une grille de compétences avec :

- Les compétences mises en avant
- Les barres de progression
- Un système de navigation par miniatures
- Le titre et la description de la section configurés dans le customizer

### Réalisations

```
[front_realisations]
```

Affiche un portfolio de projets incluant :

- Les projets avec leurs images
- Un système de navigation par miniatures
- Le titre et la description de la section configurés dans le customizer

### Contact

```
[front_contact]
```

Affiche la section contact avec :

- Le formulaire de contact (nécessite Contact Form 7)
- Les icônes de réseaux sociaux configurés
- Un design responsive adaptatif

## 🔧 Configuration WordPress Complète

### 1. Pages Requises

1. Créez une page d'accueil

   - Utilisez les shortcodes dans l'ordre souhaité
   - Exemple de structure :

   ```
   [front_presentation]
   [front_competences]
   [front_realisations]
   [front_contact]
   ```

2. Configurez les pages WordPress
   - Allez dans Réglages > Lecture
   - Sélectionnez "Une page statique" comme page d'accueil
   - Choisissez votre page créée comme "Page d'accueil"

### 2. Contact Form 7

1. Installez et activez le plugin Contact Form 7
2. Créez un nouveau formulaire
3. Copiez l'ID du formulaire
4. Insérez l'ID dans le fichier de configuration du thème

### 3. Customizer WordPress

Allez dans Apparence > Personnaliser pour configurer :

#### Section Compétences

- Titre de la section archive
- Description de la section
- Texte du lien "Voir plus"

#### Section Réalisations

- Titre de la section archive
- Description de la section
- Texte du lien "Voir plus"

### 4. Menus

1. Créez les menus dans Apparence > Menus
   - Menu Header
   - Menu Footer
2. Assignez les emplacements :
   - Navigation Header
   - Navigation Footer

### 5. Réseaux Sociaux

Dans le menu "Présentation" :

1. Configurez chaque réseau social :
   - Nom du réseau
   - URL du profil
   - Image du réseau (light/dark pour GitHub)
   - Activation/désactivation

### 6. Images et Médias

Format recommandés :

- Images de compétences : 800x600px
- Images de réalisations : 1200x800px
- Logos réseaux sociaux : 48x48px
- Format : JPG, PNG ou SVG
=======
# wp-portfolio
>>>>>>> 3fc2e4631c9ae722f4892712288f1998c32cf88b
