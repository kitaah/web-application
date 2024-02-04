import { usePage } from '@inertiajs/react';

export default function UserResources() {
    const { userResources } = usePage().props;

    return (
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">Mes Ressources</h1>
            <section className="mb-8">
                <ul className="mb-2">
                    {userResources.map(({ category_name, description, id, image, name, slug, url, created_at, updated_at }) => (
                        <li key={id}>
                            <div>Titre: <strong>{name}</strong></div><br />
                            <div>Url: <strong>{url}</strong></div><br />
                            <div>Description: <strong>{description}</strong></div><br />
                            <div>Catégorie: <strong>{category_name}</strong></div><br />
                            <div>Posté le: <strong>{created_at}</strong></div><br />
                            <div>Mise à jour le: <strong>{updated_at}</strong></div><br />
                            <img src={image} width="200" alt={name} />
                        </li>
                    ))}
                </ul>
            </section>
        </div>
    );
}
