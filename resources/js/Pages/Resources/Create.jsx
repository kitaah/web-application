import { useEffect, useState } from 'react';
import {usePage, useForm, Link} from '@inertiajs/react';
import Layout from '@/Layouts/Layout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import TextArea from '@/Components/TextArea';
import FileInput from "@/Components/FileInput";
import slugify from 'react-slugify';
import ApplicationLogo from "@/Components/ApplicationLogo.jsx";

const Create = () => {
    const { categories } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        url: '',
        slug: '',
        description: '',
        category_id: '',
        image: null,
    });

    const [isResourceAdded, setIsResourceAdded] = useState(false);

    useEffect(() => {
        return () => {
            reset('name', 'url', 'slug', 'description', 'category_id', 'image');
        };
    }, []);

    let slugTimeout;

    const generateSlug = (value) => {
        clearTimeout(slugTimeout);
        slugTimeout = setTimeout(() => {
            if (value.trim() !== '') {
                const generatedSlug = slugify(value);
                console.log('Generated Slug:', generatedSlug);
                setData('slug', generatedSlug);
            }
        }, 1000);
    };

    const handleNameChange = (e) => {
        setData('name', e.target.value);
        generateSlug(e.target.value);
    };

    const handleImageChange = (e) => {
        setData('image', e.target.files[0]);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('name', data.name);
        formData.append('url', data.url);
        formData.append('slug', data.slug);
        formData.append('description', data.description);
        formData.append('category_id', data.category_id);
        formData.append('image', data.image);

        post(route('resource.store'), formData);
    };

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Ressource</h2>}>
            <div className="container mx-auto my-8">
            <h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Créer une ressource</h2>

            <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                <div>
                    <Link href="/">
                        <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                    </Link>
                </div>

            <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form onSubmit={handleSubmit} method="POST" encType="multipart/form-data">
                <div>
                    <div className="flex items-center">
                        <InputLabel htmlFor="name" value="Nom" />
                        <span style={{ color: 'red', marginLeft: '5px' }}>*</span>
                    </div>
                    <TextInput
                        id="name"
                        name="name"
                        placeholder="Nom"
                        value={data.name}
                        className="mt-1 block w-full"
                        autoComplete="name"
                        isFocused={true}
                        onChange={handleNameChange}
                        required
                    />
                    <InputError message={errors.name} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="slug" value="Slug" />
                    <TextInput
                        id="slug"
                        name="slug"
                        value={data.slug}
                        className="mt-1 block w-full"
                        autoComplete="slug"
                        onChange={(e) => setData('slug', e.target.value)}
                        required
                    />
                    <InputError message={errors.slug} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="description" value="Description" />
                    <TextArea
                        id="description"
                        name="description"
                        placeholder="Description"
                        value={data.description}
                        className="mt-1 block w-full"
                        autoComplete="description"
                        onChange={(e) => setData('description', e.target.value)}
                        required
                    />
                    <InputError message={errors.description} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="url" value="Url" />
                    <TextInput
                        id="url"
                        name="url"
                        placeholder="Url"
                        value={data.url}
                        className="mt-1 block w-full"
                        autoComplete="url"
                        onChange={(e) => setData('url', e.target.value)}
                    />
                    <InputError message={errors.url} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="image" value="Image" />
                    <FileInput
                        type="file"
                        id="image"
                        name="image"
                        onChange={handleImageChange}
                        className="mt-1 block w-full"
                        accept="image/*"
                        required
                    />
                    <InputError message={errors.image} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="category_id" value="Catégorie" />
                    <select
                        id="category_id"
                        name="category_id"
                        value={data.category_id}
                        onChange={(e) => setData('category_id', e.target.value)}
                        className="mt-1 block w-full"
                        required
                    >
                        <option value="" disabled>Sélectionnez une catégorie</option>
                        {categories.map(category => (
                            <option key={category.id} value={category.id}>{category.name}</option>
                        ))}
                    </select>
                    <InputError message={errors.category_id} className="mt-2" />
                </div>

                <div className="flex items-center justify-end mt-4">
                    <PrimaryButton type="submit" disabled={processing}>
                        Ajouter
                    </PrimaryButton>
                </div>
            </form>
            </div>
            </div>
            </div>
        </Layout>
    );
};

export default Create;
