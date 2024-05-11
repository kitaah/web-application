import React, { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import Layout from "@/Layouts/Layout";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.jsx";
import ImageEdit from "@/Pages/Resources/ImageEdit.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import DangerButton from "@/Components/DangerButton.jsx";
import SecondaryButton from "@/Components/SecondaryButton.jsx";

export default function UserResources() {
    const { userResources, categories } = usePage().props;
    const [selectedCategory, setSelectedCategory] = useState("");

    const handleCategoryChange = (e) => {
        setSelectedCategory(e.target.value);
    };

    return (
        <Layout
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">
                    Mes ressources
                </h2>
            }
        >
            <div className="container mx-auto my-8">
                <section className="mb-8">
                    <div className="container mx-auto my-8">
                        <h1 className="text-4xl font-bold mb-4 text-center">
                            Mes ressources
                        </h1>

                        <div className="text-3xl font-bold mb-4 text-center">
                            Listing de vos ressources
                        </div>

                        <div className="text-center">
                            <button className="m-5 px-6 py-2 mt-4 text-white bg-green-500 rounded-md focus:outline-none">
                                <Link
                                    href={route("resource.create")}
                                    active={route().current("resource.create")}
                                >
                                    Ajouter une ressource
                                </Link>
                            </button>
                        </div>

                        <section className="mb-8">
                            <div className="flex justify-center items-center flex-col mb-4">
                                {" "}
                                <label
                                    htmlFor="category"
                                    className="block text-sm font-medium text-gray-700"
                                >
                                    Filtrer par catégorie
                                </label>
                                <select
                                    className="block w-2/5 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200"
                                    onChange={handleCategoryChange}
                                    value={selectedCategory}
                                >
                                    <option value="">
                                        Sélectionnez une catégorie
                                    </option>
                                    {categories.map(({ id, name }) => (
                                        <option key={id} value={name}>
                                            {name}
                                        </option>
                                    ))}
                                </select>
                            </div>

                            <div className="relative overflow-x-auto">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th
                                                scope="col"
                                                className="px-6 py-3"
                                            >
                                                Nom
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-6 py-3"
                                            >
                                                Catégorie
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-6 py-3"
                                            >
                                                Création
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-6 py-3"
                                            >
                                                Modification
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-6 py-3"
                                            >
                                                Statut
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-6 py-3 "
                                            >
                                                Voir
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-6 py-3"
                                            >
                                                Modifier la ressource
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-6 py-3"
                                            >
                                                Modifier l'image
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {userResources
                                            .filter(
                                                (resource) =>
                                                    !selectedCategory ||
                                                    resource.category_name ===
                                                        selectedCategory
                                            )
                                            .map(
                                                ({
                                                    category_name,
                                                    id,
                                                    name,
                                                    status,
                                                    slug,
                                                    created_at,
                                                    updated_at,
                                                    is_validated,
                                                }) => (
                                                    <tr
                                                        key={id}
                                                        className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                                    >
                                                        <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {name}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {category_name}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {created_at}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {updated_at}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {status}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {status ===
                                                                "En attente" ||
                                                            status ===
                                                                "Suspendue" ||
                                                            !is_validated ? (
                                                                <DangerButton>
                                                                    Indisponible
                                                                </DangerButton>
                                                            ) : (
                                                                <Link
                                                                    href={route(
                                                                        "resources.show",
                                                                        {
                                                                            slug: slug,
                                                                        }
                                                                    )}
                                                                >
                                                                    <SecondaryButton className="bg-green-500 text-white">
                                                                        Voir
                                                                    </SecondaryButton>
                                                                </Link>
                                                            )}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {status ===
                                                                "En attente" ||
                                                            status ===
                                                                "Suspendue" ||
                                                            !is_validated ? (
                                                                <DangerButton>
                                                                    Indisponible
                                                                </DangerButton>
                                                            ) : (
                                                                <Link
                                                                    href={route(
                                                                        "resource.edit",
                                                                        {
                                                                            slug: slug,
                                                                        }
                                                                    )}
                                                                >
                                                                    <SecondaryButton className="bg-red-500 text-white">
                                                                        Modifier
                                                                    </SecondaryButton>
                                                                </Link>
                                                            )}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {status ===
                                                                "En attente" ||
                                                            status ===
                                                                "Suspendue" ||
                                                            !is_validated ? (
                                                                <DangerButton>
                                                                    Indisponible
                                                                </DangerButton>
                                                            ) : (
                                                                <Link
                                                                    href={route(
                                                                        "image.edit",
                                                                        {
                                                                            slug: slug,
                                                                        }
                                                                    )}
                                                                >
                                                                    <SecondaryButton className="bg-red-500 text-white">
                                                                        Modifier
                                                                    </SecondaryButton>
                                                                </Link>
                                                            )}
                                                        </td>
                                                    </tr>
                                                )
                                            )}
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </section>
            </div>
        </Layout>
    );
}
