import Layout from '@/Layouts/Layout';

export default function TermsAndConditions() {

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Conditions Générales d'Utilisation</h2>}>
            <div className="container mx-auto my-8">
                <h1 className="text-4xl font-bold mb-4 text-center">Conditions générales d'utilisation</h1>
                <p className="text-lg mb-4 text-center">Publié le 19.06.24 - Mise à jour le 31.08.24</p>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Espace personnel</h2>
                    <p>Création de compte: Pour accéder à votre espace personnel sur notre site,
                        vous devrez créer un compte en fournissant des informations personnelles.< br/>
                        Vous êtes responsable de fournir des informations exactes et à jour lors de la création de votre compte.</p>

                    <p>Utilisation de l'espace personnel: votre espace personnel vous permettra de consulter des informations telles que votre progression, votre nombre de points et vos badges.</p>
                    <p>Suppression du compte et des données: Si vous souhaitez supprimer votre compte et vos données personnelles de notre site, veuillez nous contacter pour demander la suppression de votre compte.
                        Veuillez noter que la suppression de votre compte peut entraîner la perte définitive de vos données et de votre progression sur le site.</p>
                    <p>Modification des conditions générales d'utilisation: Nous nous réservons le droit de modifier ou de mettre à jour les conditions relatives à votre espace personnel à tout moment.<br/>
                        Toute modification des conditions générales d'utilisation sera publiée sur notre site et prendra effet dès sa publication.</p>
                    <p>En utilisant votre espace personnel sur notre site, vous acceptez de respecter ces conditions et de vous conformer à nos politiques et directives.</p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Responsabilité de l'utilisateur</h2>
                    <p>En utilisant ce site, vous acceptez de respecter les obligations suivantes:<br/>
                        Confidentialité des identifiants de connexion : Vous êtes responsable de maintenir la confidentialité de vos identifiants de connexion.
                        Ne partagez pas vos identifiants avec d'autres personnes et prenez les mesures nécessaires pour éviter tout accès non autorisé à votre compte.< br/>
                        - Utilisation appropriée : Utilisez le site conformément à sa destination et aux lois en vigueur. Ne pas utiliser le site à des fins illégales
                        ou pour des activités nuisibles, frauduleuses ou trompeuses.< br/>
                        - Intégrité du site : Ne tentez pas de nuire au bon fonctionnement du site. Cela inclut l'utilisation de logiciels malveillants, les tentatives d'accès
                        non autorisé aux zones sécurisées du site, ainsi que toute action visant à perturber ou compromettre la sécurité ou la disponibilité du site.< br/>
                        - Respect et décence : Vous vous engagez à respecter les autres utilisateurs et tiers.
                        Évitez tout comportement ou propos injurieux, diffamatoires, discriminatoires, racistes, homophobes, ou autrement offensants.< br/>
                        - Responsabilité du contenu : Vous êtes seul responsable du contenu que vous publiez sur le site.
                        Assurez-vous que votre contenu respecte les droits de propriété intellectuelle, la vie privée des autres utilisateurs
                        et les lois en vigueur.< br/>
                        Le non-respect de ces obligations peut engager votre responsabilité en cas de dommage résultant de votre conduite.< br/>
                        Nous nous réservons le droit de supprimer tout contenu qui enfreint nos directives ou qui est jugé inapproprié.< br/>
                    </p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Publications d'informations</h2>
                    <p>Si vous avez la possibilité de publier des informations sur notre site, veuillez suivre les règles d'utilisation énoncées dans les
                        conditions générales d'utilisation pour garantir un environnement respectueux et sûr pour tous les utilisateurs.</p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Droit applicable</h2>
                    <p>Les présentes CGU sont régies et interprétées conformément aux lois françaises en vigueur.< br/>
                        Tout litige découlant de l'utilisation du site sera soumis à la juridiction exclusive des tribunaux français.</p>
                </section>
            </div>
        </Layout>
    );
};
