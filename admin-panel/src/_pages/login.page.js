import { Box, Badge, Image, StarIcon, Center, Stack, Input, Button } from "@chakra-ui/react";

export default function LoginPage() {
  const property = {
    imageUrl: "https://bit.ly/2Z4KKcF",
    imageAlt: "Rear view of modern home with pool",
    beds: 3,
    baths: 2,
    title: "Modern home in city center in the heart of historic Los Angeles",
    formattedPrice: "$1,900.00",
    reviewCount: 34,
    rating: 4,
  };

  return (
    <Center>
      <Box maxW="lg" borderWidth="1px" borderRadius="lg" overflow="hidden" mt="20">
        <Box p="6">
            <Box
            p="5"
            fontWeight="semibold"
            as="h1"
            fontSize="lg"
            lineHeight="tight"
          >
            Personal Blog
          </Box>
          <Stack spacing={3}>
            <Input placeholder="Email" size="md" />
            <Input placeholder="Password" size="md" />
          </Stack>   
          <Box d="flex" mt="6" alignItems="center">
             <Button colorScheme="teal" w="100%">Login</Button> 
          </Box>
        </Box>
      </Box>
    </Center>
  );
}
