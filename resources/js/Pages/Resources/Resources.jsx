import { Link, usePage } from '@inertiajs/react';

export default function Resources() {
    const { resources } = usePage().props;

    return (
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">Liste des ressources</h1>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2 text-center">Consultez la liste des ressources</h2>
                <ul className="mb-2">
                    {resources.map(({ category_name, description, id, image, name, slug, url, user_name, created_at, updated_at }) => (
                        <li key={id}>
                            <div>Titre: <strong>{name}</strong></div><br />
                            <div>Url: <strong>{url}</strong></div><br />
                            <div>Description: <strong>{description}</strong></div><br />
                            <div>Slug: <strong>{slug}</strong></div><br />
                            <div>Catégorie: <strong>{category_name}</strong></div><br />
                            <div>Posté par: <strong>{user_name}</strong></div><br />
                            <div>Posté le: <strong>{created_at}</strong></div><br />
                            <div>Mise à jour le: <strong>{updated_at}</strong></div><br />
                            <img src={image} width="200" alt={name} />
                            <Link href={`/ressource/${slug}`}>
                                <button className="px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">Voir la ressource</button>
                            </Link>
                        </li>
                    ))}
                </ul>
            </section>
        </div>
    );
};
