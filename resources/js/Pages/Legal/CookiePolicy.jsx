import Layout from '@/Layouts/Layout';

export default function CookiePolicy() {

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Politique de cookies</h2>}>
            <div className="container mx-auto my-8">
                <h1 className="text-4xl font-bold mb-4 text-center">Politique de cookies</h1>
                <p className="text-lg mb-4 text-center">Publié le 19.02.24 - Mise à jour le 29.09.24</p>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Présentation</h2>
                    <p>Cette politique de cookies explique comment notre site utilise les cookies pour améliorer votre expérience en ligne.</p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Qu'est ce qu'un cookie ?</h2>
                    <p>Un cookie est un petit fichier texte qui est stocké sur votre ordinateur ou votre appareil mobile lorsque vous visitez un site site.<br/>
                        Les cookies permettent au site de se souvenir de vos actions et préférences (telles que la connexion automatique ou la langue préférée) sur une période de temps,
                        vous évitant ainsi de saisir ces informations à chaque visite ou lorsque vous naviguez entre les pages.
                    </p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Cookie utilisé</h2>
                    <p>Nous utilisons uniquement un cookie pour vous permettre de rester connecté automatiquement lors de vos visites ultérieures.< br/>
                        Ce cookie est utilisé uniquement à des fins de fonctionnement du site et n'est pas utilisé à des fins de suivi ou de collecte de données personnelles.
                    </p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Contrôles des cookies</h2>
                    <p>Vous pouvez contrôler et/ou supprimer les cookies selon vos préférences.<br/>
                        Vous pouvez supprimer tous les cookies déjà stockés sur votre ordinateur et configurer la plupart des navigateurs pour empêcher leur stockage.
                    </p>
                </section>

                <section className="mb-8">
                    <h2 className="text-2xl font-bold mb-2">Révision</h2>
                    <p>Nous nous réservons le droit de modifier cette politique de cookies à tout moment en publiant une version mise à jour sur notre site.<br/></p>
                </section>
            </div>
        </Layout>
    );
};
